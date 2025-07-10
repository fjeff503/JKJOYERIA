<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Http\Requests\Purchase\StorePurchaseRequest;
use App\Http\Requests\Purchase\UpdatePurchaseRequest;
use App\Models\Fail;
use App\Models\Provider;
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
    
            return redirect('purchases')->with('success', 'Compra registrada correctamente');
        } catch (\Throwable $th) {
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
                return redirect('purchases')->with('error', 'Error no reconocido: ' . $th->getMessage());
            }
        }
    }

    public function edit(Purchase $purchase)
    {
        // Extraemos los proveedores
        $providers = Provider::get();
        // Mostrar la vista
        return view('/purchase/update')->with([
            'purchase' => $purchase,
            'providers' => $providers
        ]);
    }

    public function update(UpdatePurchaseRequest $request, $idPurchase)
    {
        try {
            // Traemos la compra
            $purchase = Purchase::findOrFail($idPurchase);
    
            // Actualizamos campos desde el request
            $purchase->total = $request->input('total');
            $purchase->idProvider = $request->input('idProvider');
            $purchase->idUser = auth()->id(); // usuario en sesión
    
            // Si se subió un nuevo voucher
            if ($request->hasFile('voucher')) {
                // Elimina el anterior si existía
                if ($purchase->voucher) {
                    $relativePath = parse_url($purchase->voucher, PHP_URL_PATH);
                    Storage::disk('s3')->delete($relativePath);
                }
    
                // Guarda el nuevo voucher
                $path = $request->file('voucher')->store('vouchers', 's3');
                $purchase->voucher = Storage::disk('s3')->url($path);
            }
    
            // Guardamos
            $purchase->save();
    
            return redirect('purchases')->with('success', 'Compra actualizada correctamente');
        } catch (\Throwable $th) {
            try {
                Fail::create([
                    'tableName' => 'purchases',
                    'action' => 'update',
                    'message' => $th->getMessage(),
                    'file' => $th->getFile(),
                    'line' => $th->getLine(),
                ]);
    
                return redirect('purchases')->with(array(
                    'error' => 'La acción no pudo ser realizada',
                ));
            } catch (\Throwable $th) {
                return redirect('purchases')->with(array(
                    'error' => 'Error no reconocido',
                ));
            }
        }
    }

    public function destroy(Purchase $purchase)
    {
        try {
            // Si tiene imagen de perfil, eliminarla del bucket S3
            if ($purchase->voucher && filter_var($purchase->voucher, FILTER_VALIDATE_URL)) {
                $relativePath = ltrim(parse_url($purchase->voucher, PHP_URL_PATH), '/');
                Storage::disk('s3')->delete($relativePath);
            }
    
            // Eliminar usuario (soft delete)
            $purchase->delete();
    
            return response()->json(['res' => true]);
        } catch (\Throwable $e) {
            return response()->json(['res' => false, 'error' => $e->getMessage()], 500);
        }
    }
}
