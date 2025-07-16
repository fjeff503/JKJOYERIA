<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Http\Requests\Purchase\StorePurchaseRequest;
use App\Http\Requests\Purchase\UpdatePurchaseRequest;
use App\Models\Fail;
use App\Models\Product;
use App\Models\Provider;
use App\Models\PurchaseDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PurchaseController extends Controller
{
    public function index()
    {
        //Extraemos las Compras
        $data = Purchase::select(
            'purchases.idPurchase',
            'purchases.total',
            'purchases.voucher',
            'providers.name as provider',
            'users.name as user',
            DB::raw("DATE_FORMAT(purchases.created_at, '%d/%m/%Y %H:%i') as date")
        )
            ->join('providers', 'providers.idProvider', '=', 'purchases.idProvider')
            ->join('users', 'users.id', '=', 'purchases.idUser')
            ->get();
        
            return view('/purchase/index')->with(['data' => $data]);
    }

    public function create()
    {
        //extraemos los proveedores
        $providers = Provider::get();

        return view('/purchase/create', compact('providers'));
    }

    public function store(StorePurchaseRequest $request)
    {
        DB::beginTransaction();  // Inicia la transacción
        try {
            // Validamos la data
            $validatedData = $request->validated();
    
            // Crear la compra
            $purchase = Purchase::create([
                'total' => $validatedData['total'],
                'idProvider' => $validatedData['idProvider'],
                'idUser' => auth()->id(), // ID del usuario autenticado
            ]);
    
            // Si se subió un archivo de voucher
            if ($request->hasFile('voucher')) {
                $file = $request->file('voucher');
                $path = $file->store('vouchers', 's3'); // Cambia a 'public' si no usás S3
                $url = Storage::disk('s3')->url($path);
    
                // Guardar la URL en el campo 'voucher'
                $purchase->update(['voucher' => $url]);
            }
    
            // Guardar los detalles de productos
            $productos = json_decode($request->input('detalle'), true);
            
            if (!$productos || !is_array($productos)) {
                return redirect('purchases')->with('error', 'No se encontraron productos para registrar.');
            }
        
            //recorremos el arreglo del detalle
            foreach ($productos as $item) {
            // 1. Guardar el detalle
            PurchaseDetail::create([
                'idPurchase' => $purchase->idPurchase,
                'idProduct' => $item['idProduct'],
                'quantity' => $item['cantidad'],
                'price' => $item['buyPrice'],
            ]);
        
            // 2. Actualizar el stock y precio del producto
            $producto = Product::find($item['idProduct']);
            if ($producto) {
                $producto->stock += $item['cantidad']; // quantity según la base
                $producto->buyPrice = $item['buyPrice']; // buyPrice nuevo
                $producto->save();
            }
        }
            DB::commit();  // Confirma la transacción si todo fue bien
            return redirect('purchases')->with('success', 'Compra registrada correctamente');
        } catch (\Throwable $th) {
            DB::rollBack();  // Deshace todo si hubo error
            try {
                Fail::create([
                    'tableName' => 'purchases',
                    'action' => 'store',
                    'message' => $th->getMessage(),
                    'file' => $th->getFile(),
                    'line' => $th->getLine()
                ]);
    
                return redirect('purchases')->with('error', 'La acción no pudo ser realizada');
            } catch (\Throwable $th) {
                return redirect('purchases')->with('error', 'Error no reconocido');
            }
        }
    }

    public function edit(Purchase $purchase)
    {
        // Extraemos los proveedores
        $providers = Provider::get();

        // Cargar los detalles relacionados con la compra
        $purchase_details = PurchaseDetail::select(
        'purchase_details.idPurchaseDetail',
        'products.idProduct as idProduct',
        'products.name as product',
        'products.sellPrice as sellPrice',
        'purchase_details.price',
        'purchase_details.quantity'
        )
        ->join('products', 'products.idProduct', '=', 'purchase_details.idProduct')
        ->where('purchase_details.idPurchase', $purchase->idPurchase)
        ->get();

        // Mostrar la vista
        return view('/purchase/update')->with([
            'purchase' => $purchase,
            'purchase_details' => $purchase_details,
            'providers' => $providers
        ]);
    }

    public function update(UpdatePurchaseRequest $request, $idPurchase)
    {
        try {
            DB::beginTransaction();

            // Actualizar la compra
            try {
                 // Traemos la compra
                $purchase = Purchase::findOrFail($idPurchase);

                // Actualizamos campos principales
                $purchase->total = $request->input('total');
                $purchase->idProvider = $request->input('idProvider');
                $purchase->idUser = auth()->id();

                // Voucher nuevo
                if ($request->hasFile('voucher')) {
                    if ($purchase->voucher) {
                        $relativePath = parse_url($purchase->voucher, PHP_URL_PATH);
                        Storage::disk('s3')->delete($relativePath);
                    }
                
                    $path = $request->file('voucher')->store('vouchers', 's3');
                    $purchase->voucher = Storage::disk('s3')->url($path);
                }
            
                $purchase->save();
            } catch (\Throwable $ePurchase) {
                Fail::create([
                    'tableName' => 'purchases',
                    'action' => 'update',
                    'message' => $ePurchase->getMessage(),
                    'file' => $ePurchase->getFile(),
                    'line' => $ePurchase->getLine(),
                ]);
                throw $ePurchase; // para que caiga al rollback global
            }

            // Procesar detalle de productos
            try {
                $detallesNuevos = json_decode($request->input('detalle'), true);

                $idsDetalleProcesados = [];

                foreach ($detallesNuevos as $detalle) {
                    $detalleDB = PurchaseDetail::where('idPurchase', $purchase->idPurchase)
                        ->where('idProduct', $detalle['idProduct'])
                        ->first();
                
                    $producto = Product::findOrFail($detalle['idProduct']);
                
                    if ($detalleDB) {
                        // Si ya existía, actualizamos stock si cambió la cantidad
                        $diferenciaCantidad = $detalle['cantidad'] - $detalleDB->quantity;
                        $producto->stock += $diferenciaCantidad;
                        $producto->save();
                    
                        // Actualizamos el detalle
                        $detalleDB->price = $detalle['buyPrice'];
                        $detalleDB->quantity = $detalle['cantidad'];
                        $detalleDB->save();
                    
                        $idsDetalleProcesados[] = $detalleDB->idPurchaseDetail;
                    } else {
                        // Si no existía, creamos nuevo y actualizamos stock
                        $nuevoDetalle = PurchaseDetail::create([
                            'idPurchase' => $purchase->idPurchase,
                            'idProduct' => $detalle['idProduct'],
                            'price' => $detalle['buyPrice'],
                            'quantity' => $detalle['cantidad']
                        ]);
                    
                        $producto->stock += $detalle['cantidad'];
                        $producto->save();

                        //agregar al arreglo para que no lo borre después
                        $idsDetalleProcesados[] = $nuevoDetalle->idPurchaseDetail;
                    }
                }
                    } catch (\Throwable $eDetalle) {
                        Fail::create([
                            'tableName' => 'purchase_details',
                            'action' => 'update',
                            'message' => $eDetalle->getMessage(),
                            'file' => $eDetalle->getFile(),
                            'line' => $eDetalle->getLine(),
                        ]);
                        throw $eDetalle;
                    }

                    // Eliminar detalles que ya no están (si deseás esta parte)
                    PurchaseDetail::where('idPurchase', $purchase->idPurchase)
                    ->whereNotIn('idPurchaseDetail', $idsDetalleProcesados)
                    ->each(function ($detalleAntiguo) {
                        // Reducir el stock porque ya no está en la compra
                        $producto = Product::find($detalleAntiguo->idProduct);
                        if ($producto) {
                            $producto->stock = max(0, $producto->stock - $detalleAntiguo->quantity);
                            $producto->save();
                        }
                    
                        $detalleAntiguo->delete();
                    });
                
                    DB::commit();
                    return redirect('purchases')->with('success', 'Compra actualizada correctamente');

            } catch (\Throwable $th) {
                DB::rollBack();
                return redirect('purchases')->with('error', 'La acción no pudo ser realizada');
            }
    }

    public function destroy(Purchase $purchase)
    {
        DB::beginTransaction();
        try {
            // 1. Eliminar imagen del voucher del bucket S3 si existe
            if ($purchase->voucher && filter_var($purchase->voucher, FILTER_VALIDATE_URL)) {
                $relativePath = ltrim(parse_url($purchase->voucher, PHP_URL_PATH), '/');
                Storage::disk('s3')->delete($relativePath);
            }

            // 2. Obtener los detalles de la compra
            $detalles = PurchaseDetail::where('idPurchase', $purchase->idPurchase)->get();

            // 3. Revertir el stock de los productos y eliminar los detalles
            foreach ($detalles as $detalle) {
                $producto = Product::find($detalle->idProduct);
                if ($producto) {
                    // Reducir el stock
                    $producto->stock = max(0, $producto->stock - $detalle->quantity);
                    $producto->save();
                }

                // Eliminar el detalle (soft delete o delete real según tu modelo)
                $detalle->delete();
            }

            // 4. Eliminar la compra (soft delete)
            $purchase->delete();

            DB::commit();
            return response()->json(['res' => true]);

        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['res' => false, 'error' => $e->getMessage()], 500);
        }
    }
}
