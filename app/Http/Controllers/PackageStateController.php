<?php

namespace App\Http\Controllers;

use App\Models\PackageState;
use App\Http\Requests\PackageState\StorePackageStateRequest;
use App\Http\Requests\PackageState\UpdatePackageStateRequest;
use App\Models\Fail;

class PackageStateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Extraemos los estados de paquetes
        $data = PackageState::all();

        return view('/admin/package_state/index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('/admin/package_state/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePackageStateRequest $request)
    {
        try {
            // Validamos la data
            $validatedData = $request->validated();

            // Verificar si ya existe un estado de paquete con el mismo nombre (incluyendo las eliminadas lógicamente)
            $existingPackageState = PackageState::withTrashed()->where('name', $validatedData['name'])->first();

            if ($existingPackageState) {
                // Si ya existe un estado de paquete con el mismo nombre, verifica si está eliminada lógicamente
                if ($existingPackageState->trashed()) {
                    // Restaurar lógicamente
                    $existingPackageState->restore();
                    return redirect('package_states')->with('info', 'Estado de paquetes restaurado correctamente');
                }
            }

            // Si no existe una categoría con el mismo nombre, crea una nueva categoría
            PackageState::create($validatedData);

            return redirect('package_states')->with('success', 'Estado de paquete creado correctamente');
        } catch (\Throwable $th) {
            try {
                // Retornamos el mensaje
                Fail::create(array(
                    'tableName' => 'package_states',
                    'action' => 'store',
                    'message' => $th->getMessage(),
                    'file' => $th->getFile(),
                    'line' => $th->getLine()
                ));
                return redirect('package_states')->with(array(
                    'error' => 'La acción no pudo ser realizada',
                ));
            } catch (\Throwable $th) {
                return redirect('package_states')->with(array(
                    'error' => 'Error no reconocido',
                ));
            }
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(packageState $packageState)
    {
        //Mostrar la vista 
        return view('/admin/package_state/update')->with(['data' => $packageState]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatepackageStateRequest $request, $idPackageState)
    {
        //intento
        try {
            //traemos la data si el iteme que estamos modificando
            $packageState = PackageState::findOrFail($idPackageState);

            // Verificar si el nuevo valor del campo "name" ya existe en otro registro
            if ($packageState->name !== $request->input('name') && PackageState::where('name', $request->input('name'))->exists()) {
                return redirect()->back()->withErrors(['name' => 'El estado de paquete ya existe.'])->withInput();
            }

            //actualizamos los datos
            $packageState->name = $request->input('name');
            $packageState->description = $request->input('description');

            //guardamos los cambios
            $packageState->save();

            //retornamos a la vista principal
            return redirect('package_states')->with('success', 'Estado de paquete actualizado correctamente');
        } catch (\Throwable $th) {
            try {
                // Retornamos el mensaje
                Fail::create(array(
                    'tableName' => 'package_states',
                    'action' => 'update',
                    'message' => $th->getMessage(),
                    'file' => $th->getFile(),
                    'line' => $th->getLine()
                ));
                return redirect('package_states')->with(array(
                    'error' => 'La acción no pudo ser realizada',
                ));
            } catch (\Throwable $th) {
                return redirect('package_states')->with(array(
                    'error' => 'Error no reconocido',
                ));
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PackageState $packageState)
    {
        $packageState->delete();
        //Retornar una respuesta json
        return response()->json(array('res' => true));
    }
}
