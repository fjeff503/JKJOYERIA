<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Http\Requests\Sale\StoreSaleRequest;
use App\Http\Requests\Sale\UpdateSaleRequest;
use App\Models\Client;
use App\Models\DeliveryPoint;
use App\Models\Fail;
use App\Models\packageState;
use App\Models\paymentState;
use App\Models\Product;
use App\Models\SaleDetail;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public function index()
    {
        //Extraemos las Compras
        $data = Sale::select(
            'sales.idSale',
            DB::raw("DATE_FORMAT(sales.created_at, '%d/%m/%Y %H:%i') as date"),
            'sales.total',
            'sales.description',
            'clients.name as client',
            'clients.phone as phone',
            'delivery_points.name as delivery_point',
            'package_states.name as package_state',
            'payment_states.name as payment_state',
            'users.name as user',
            
        )
            ->join('clients', 'clients.idClient', '=', 'sales.idClient')
            ->join('delivery_points', 'delivery_points.idDeliveryPoint', '=', 'sales.idDeliveryPoint')
            ->join('package_states', 'package_states.idPackageState', '=', 'sales.idPackageState')
            ->join('payment_states', 'payment_states.idPaymentState', '=', 'sales.idPaymentState')
            ->join('users', 'users.id', '=', 'sales.idUser')
            ->get();
        
            return view('/sale/index')->with(['data' => $data]);
    }

    public function create()
    {
        //extraemos los clientes
        $clients = Client::orderBy('created_at', 'desc')->get();

        //extraemos los puntos de entrega
        $delivery_points = DeliveryPoint::select(
            'delivery_points.idDeliveryPoint',
            'delivery_points.name',
            'delivery_points.hour',
            'delivery_points.description',
            'parcels.name as parcel',
            'days.name as day',
        )
        ->join('parcels', 'parcels.idParcel', '=', 'delivery_points.idParcel')
        ->join('days', 'days.idDay', '=', 'delivery_points.idDay')
        ->get();

        //extraemos los estados de paquetes
        $package_states = packageState::get();

        //extraemos los estados de pago
        $payment_states = paymentState::get();

        return view('/sale/create', compact('clients', 'delivery_points', 'package_states', 'payment_states'));
    }

    public function store(StoreSaleRequest $request)
    {
        DB::beginTransaction();  // Inicia la transacción
        try {
            // Validamos la data
            $validatedData = $request->validated();
    
            // Crear la compra
            $sale = Sale::create([
                'total' => $validatedData['total'],
                'description' => $validatedData['description'],
                'idClient' => $validatedData['idClient'],
                'idDeliveryPoint' => $validatedData['idDeliveryPoint'],
                'idPackageState' => $validatedData['idPackageState'],
                'idPaymentState' => $validatedData['idPaymentState'],
                'idUser' => auth()->id(), // ID del usuario autenticado
            ]);
    
            $sale->save();

            // Guardar los detalles de productos
            $productos = json_decode($request->input('detalle'), true);
            
            if (!$productos || !is_array($productos)) {
                return redirect('sales')->with('error', 'No se encontraron productos para registrar.');
            }
        
            //recorremos el arreglo del detalle
            foreach ($productos as $item) {
            // 1. Guardar el detalle
            SaleDetail::create([
                'idSale' => $sale->idSale,
                'idProduct' => $item['idProduct'],
                'quantity' => $item['cantidad'],
                'price' => $item['sellPrice'],
                'discount' => $item['discount'],
            ]);
        
            // 2. Actualizar el stock y precio del producto
            $producto = Product::find($item['idProduct']);
            if ($producto) {
                $producto->stock -= $item['cantidad']; // quantity según la base
                $producto->save();
            }
        }
            DB::commit();  // Confirma la transacción si todo fue bien
            return redirect('sales')->with('success', 'Venta registrada correctamente');
        } catch (\Throwable $th) {
            DB::rollBack();  // Deshace todo si hubo error
            try {
                Fail::create([
                    'tableName' => 'sales',
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

    public function edit(Sale $sale)
    {

        $sale->load(['client', 'deliveryPoint']);
        
         // Solo campos necesarios de clientes
        $clients = Client::select('idClient','phone','whatsapp', 'name')
        ->orderBy('created_at', 'desc')
        ->get();

        //extraemos los puntos de entrega
        $delivery_points = DeliveryPoint::select(
            'delivery_points.idDeliveryPoint',
            'delivery_points.name',
            'delivery_points.hour',
            'delivery_points.description',
            'parcels.name as parcel',
            'days.name as day',
        )
        ->join('parcels', 'parcels.idParcel', '=', 'delivery_points.idParcel')
        ->join('days', 'days.idDay', '=', 'delivery_points.idDay')
        ->get();

        //extraemos los estados de paquetes
        $package_states = packageState::get();

        //extraemos los estados de pago
        $payment_states = paymentState::get();

        // Cargar los detalles relacionados con la compra
        $sale_details = SaleDetail::select(
            'sale_details.idSaleDetail',
            'sale_details.quantity',
            'sale_details.price',
            'sale_details.discount',
            'products.idProduct as idProduct',
            'products.name as product',
            'products.stock' // <--- Asegúrate de incluirlo aquí
        )
        ->join('products', 'products.idProduct', '=', 'sale_details.idProduct')
        ->where('sale_details.idSale', $sale->idSale)
        ->get();

        // Mostrar la vista
        return view('/sale/update')->with([
            'sale'=>$sale,
            'clients' => $clients,
            'delivery_points' => $delivery_points,
            'package_states' => $package_states,
            'payment_states' => $payment_states,
            'sale_details' => $sale_details
        ]);
    }

    public function update(UpdateSaleRequest $request, $idSale)
{
    try {
        DB::beginTransaction();

        // Actualizar la venta principal
        $sale = Sale::findOrFail($idSale);

        $sale->total = $request->input('total');
        $sale->description = $request->input('description');
        $sale->idClient = $request->input('idClient');
        $sale->idDeliveryPoint = $request->input('idDeliveryPoint');
        $sale->idPackageState = $request->input('idPackageState');
        $sale->idPaymentState = $request->input('idPaymentState');
        $sale->idUser = auth()->id();

        $sale->save();

        // Procesar detalles nuevos o actualizados
        $detallesNuevos = json_decode($request->input('detalle'), true);

        $idsDetalleProcesados = [];

        foreach ($detallesNuevos as $detalle) {
            $detalleDB = SaleDetail::where('idSale', $sale->idSale)
                ->where('idProduct', $detalle['idProduct'])
                ->first();

            $producto = Product::findOrFail($detalle['idProduct']);

            if ($detalleDB) {
                // Restaurar el stock anterior antes de actualizar
                $producto->stock += $detalleDB->quantity;
                // Restar el stock con la nueva cantidad
                $producto->stock -= $detalle['cantidad'];
                $producto->save();

                // Actualizar detalle
                $detalleDB->price = $detalle['price']; 
                $detalleDB->discount = $detalle['discount'];
                $detalleDB->quantity = $detalle['cantidad'];
                $detalleDB->save();

                $idsDetalleProcesados[] = $detalleDB->idSaleDetail;
            } else {
                // Crear nuevo detalle
                $nuevoDetalle = SaleDetail::create([
                    'idSale' => $sale->idSale,
                    'idProduct' => $detalle['idProduct'],
                    'price' => $detalle['price'],
                    'discount' => $detalle['discount'],
                    'quantity' => $detalle['cantidad']
                ]);

                $producto->stock -= $detalle['cantidad'];
                $producto->save();

                $idsDetalleProcesados[] = $nuevoDetalle->idSaleDetail;
            }
        }

        // Eliminar detalles que no están en el arreglo nuevo
        SaleDetail::where('idSale', $sale->idSale)
            ->whereNotIn('idSaleDetail', $idsDetalleProcesados)
            ->each(function ($detalleAntiguo) {
                $producto = Product::find($detalleAntiguo->idProduct);
                if ($producto) {
                    // Restaurar stock antes de borrar el detalle
                    $producto->stock += $detalleAntiguo->quantity;
                    $producto->save();
                }
                $detalleAntiguo->delete();
            });

        DB::commit();

        return redirect('sales')->with('success', 'Venta actualizada correctamente');

    } catch (\Throwable $th) {
        DB::rollBack();
        try {
                Fail::create([
                    'tableName' => 'sales',
                    'action' => 'update',
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


    public function destroy(Sale $sale)
    {
        DB::beginTransaction();
        try {
            // 1. Obtener los detalles de la compra
            $detalles = SaleDetail::where('idSale', $sale->idSale)->get();

            // 2. Revertir el stock de los productos y eliminar los detalles
            foreach ($detalles as $detalle) {
                $producto = Product::find($detalle->idProduct);
                if ($producto) {
                    // Reducir el stock
                    $producto->stock = max(0, $producto->stock + $detalle->quantity);
                    $producto->save();
                }

                // Eliminar el detalle (soft delete o delete real según tu modelo)
                $detalle->delete();
            }

            // 3. Eliminar la compra (soft delete)
            $sale->delete();

            DB::commit();
            return response()->json(['res' => true]);

        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['res' => false, 'error' => $e->getMessage()], 500);
        }
    }
}
