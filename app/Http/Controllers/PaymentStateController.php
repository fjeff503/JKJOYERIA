<?php

namespace App\Http\Controllers;

use App\Models\PaymentState;
use App\Http\Requests\PaymentState\StorePaymentStateRequest;
use App\Http\Requests\PaymentState\UpdatePaymentStateRequest;
use App\Models\Fail;

class PaymentStateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Extraemos los estados de paquetes
        $data = PaymentState::all();

        return view('/payment_state/index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('/payment_state/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePaymentStateRequest $request)
    {
        try {
            // Validamos la data
            $validatedData = $request->validated();

            // Verificar si ya existe un estado de paquete con el mismo nombre (incluyendo las eliminadas lógicamente)
            $existingPaymentState = PaymentState::withTrashed()->where('name', $validatedData['name'])->first();

            if ($existingPaymentState) {
                // Si ya existe un estado de paquete con el mismo nombre, verifica si está eliminada lógicamente
                if ($existingPaymentState->trashed()) {
                    // Restaurar lógicamente
                    $existingPaymentState->restore();
                    return redirect('payment_states')->with('info', 'Estado de pago restaurado correctamente');
                }
            }

            // Si no existe una categoría con el mismo nombre, crea una nueva categoría
            PaymentState::create($validatedData);

            return redirect('payment_states')->with('success', 'Estado de pago creado correctamente');
        } catch (\Throwable $th) {
            try {
                // Retornamos el mensaje
                Fail::create(array(
                    'tableName' => 'payment_states',
                    'action' => 'store',
                    'message' => $th->getMessage(),
                    'file' => $th->getFile(),
                    'line' => $th->getLine()
                ));
                return redirect('payment_states')->with(array(
                    'error' => 'La acción no pudo ser realizada',
                ));
            } catch (\Throwable $th) {
                return redirect('payment_states')->with(array(
                    'error' => 'Error no reconocido',
                ));
            }
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PaymentState $paymentState)
    {
        //Mostrar la vista 
        return view('/payment_state/update')->with(['data' => $paymentState]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePaymentStateRequest $request, $idPaymentState)
    {
        //intento
        try {
            //traemos la data si el iteme que estamos modificando
            $paymentState = PaymentState::findOrFail($idPaymentState);

            // Verificar si el nuevo valor del campo "name" ya existe en otro registro
            if ($paymentState->name !== $request->input('name') && PaymentState::where('name', $request->input('name'))->exists()) {
                return redirect()->back()->withErrors(['name' => 'El estado de pago ya existe.'])->withInput();
            }

            //actualizamos los datos
            $paymentState->name = $request->input('name');
            $paymentState->description = $request->input('description');

            //guardamos los cambios
            $paymentState->save();

            //retornamos a la vista principal
            return redirect('payment_states')->with('success', 'Estado de pago actualizado correctamente');
        } catch (\Throwable $th) {
            try {
                // Retornamos el mensaje
                Fail::create(array(
                    'tableName' => 'payment_states',
                    'action' => 'update',
                    'message' => $th->getMessage(),
                    'file' => $th->getFile(),
                    'line' => $th->getLine()
                ));
                return redirect('payment_states')->with(array(
                    'error' => 'La acción no pudo ser realizada',
                ));
            } catch (\Throwable $th) {
                return redirect('payment_states')->with(array(
                    'error' => 'Error no reconocido',
                ));
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PaymentState $paymentState)
    {
        $paymentState->delete();
        //Retornar una respuesta json
        return response()->json(array('res' => true));
    }
}
