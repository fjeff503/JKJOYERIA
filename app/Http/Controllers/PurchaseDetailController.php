<?php

namespace App\Http\Controllers;

use App\Models\PurchaseDetail;
use App\Http\Requests\PurchaseDetail\StorePurchaseDetailRequest;
use App\Http\Requests\PurchaseDetail\UpdatePurchaseDetailRequest;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class PurchaseDetailController extends Controller
{
    public function destroy($id)
    {
        DB::beginTransaction();
        try {              
            // Eliminar PurchaseDetail (soft delete)
            $detalle = PurchaseDetail::findOrFail($id);

            // Obtener el producto asociado
            $producto = Product::find($detalle->idProduct);

            if ($producto) {
            // Restar la cantidad del stock actual
                $producto->stock = max(0, $producto->stock - $detalle->quantity); // Evita stock negativo
                $producto->save();
            }


            $detalle->delete();

            DB::commit();
            return response()->json(['res' => true]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['res' => false, 'error' => $e->getMessage()], 500);
        }
    }
}
