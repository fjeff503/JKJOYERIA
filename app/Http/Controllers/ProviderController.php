<?php

namespace App\Http\Controllers;

use App\Models\Provider;
use App\Models\Fail;
use Illuminate\Http\Request;
use App\Http\Requests\Provider\StoreProviderRequest;
use App\Http\Requests\Provider\UpdateProviderRequest;

class ProviderController extends Controller
{
    public function index(Request $request)
    {
        //Extraemos los proveedores
        $data = Provider::all();

        return view('/admin/provider/index', compact('data'));
    }

    public function create()
    {
        return view('/admin/provider/create');
    }

    public function store(StoreProviderRequest $request)
    {
        try {
            // Validamos la data
            $validatedData = $request->validated();

            // Verificar si ya existe un encomendista con el mismo nombre (incluyendo las eliminadas lógicamente)
            $existingName = Provider::withTrashed()->where('name', $validatedData['name'])->first();
            // Verificar si ya existe un encomendista con el mismo telefono (incluyendo las eliminadas lógicamente)
            $existingPhone = Provider::withTrashed()->where('phone', $validatedData['phone'])->first();
            // Verificar si ya existe un encomendista con el mismo whatsapp (incluyendo las eliminadas lógicamente)
            $existingWhatsapp = Provider::withTrashed()->where('whatsapp', $validatedData['whatsapp'])->first();
            // Verificar si ya existe un encomendista con el mismo facebook (incluyendo las eliminadas lógicamente)
            $existingFacebook = Provider::withTrashed()->where('facebook', $validatedData['facebook'])->first();

            //para Nombre
            if ($existingName) {
                // Si ya existe un Proveedor con el mismo telefono, verifica si está eliminada lógicamente
                if ($existingName->trashed() != null) {
                    // Restaurar el Proveedor eliminado lógicamente
                    $existingName->restore();
                    return redirect('providers')->with('info', 'Proveedor restaurado correctamente');
                }
            }

            //para Telefono
            if ($existingPhone) {
                // Si ya existe un Proveedor con el mismo telefono, verifica si está eliminada lógicamente
                if ($existingPhone->trashed() != null) {
                    // Restaurar el Proveedor eliminado lógicamente
                    $existingPhone->restore();
                    return redirect('providers')->with('info', 'Proveedor restaurado correctamente');
                }
            }

            //para Whatsapp
            if ($existingWhatsapp) {
                // Si ya existe un Proveedor con el mismo telefono, verifica si está eliminada lógicamente
                if ($existingWhatsapp->trashed() != null) {
                    // Restaurar el Proveedor eliminado lógicamente
                    $existingWhatsapp->restore();
                    return redirect('providers')->with('info', 'Proveedor restaurado correctamente');
                }
            }

            //para Facebook
            if ($existingFacebook) {
                // Si ya existe un Proveedor con el mismo telefono, verifica si está eliminada lógicamente
                if ($existingFacebook->trashed() != null) {
                    // Restaurar el Proveedor eliminado lógicamente
                    $existingFacebook->restore();
                    return redirect('providers')->with('info', 'Proveedor restaurado correctamente');
                }
            }

            // Si no existe un Proveedor con el mismo nombre, crea un nuevo Proveedor
            Provider::create($validatedData);

            return redirect('providers')->with('success', 'Proveedor creado correctamente');
        } catch (\Throwable $th) {
            try {
                // Retornamos el mensaje
                Fail::create(array(
                    'tableName' => 'providers',
                    'action' => 'store',
                    'message' => $th->getMessage(),
                    'file' => $th->getFile(),
                    'line' => $th->getLine()
                ));
                return redirect('providers')->with(array(
                    'error' => 'La acción no pudo ser realizada',
                ));
            } catch (\Throwable $th) {
                return redirect('providers')->with(array(
                    'error' => 'Error no reconocido',
                ));
            }
        }
    }


    public function edit(Provider $provider)
    {
        //Mostrar la vista 
        return view('/admin/provider/update')->with(['provider' => $provider]);
    }

    public function update(UpdateProviderRequest $request, $idProvider)
    {
        //intento
        try {
            //traemos la data si el iteme que estamos modificando
            $provider = Provider::findOrFail($idProvider);

            // Verificar si el nuevo valor del campo "telefono" ya existe en otro registro
            if ($provider->name !== $request->input('name') && Provider::where('name', $request->input('name'))->exists()) {
                return redirect()->back()->withErrors(['name' => 'El nombre ya está siendo utilizado por otro registro.'])->withInput();
            } else if ($provider->phone !== $request->input('phone') && Provider::where('phone', $request->input('phone'))->exists()) {
                return redirect()->back()->withErrors(['phone' => 'El teléfono ya está siendo utilizado por otro registro.'])->withInput();
            } else if ($provider->whatsapp !== $request->input('whatsapp') && Provider::where('whatsapp', $request->input('whatsapp'))->exists()) {
                return redirect()->back()->withErrors(['whatsapp' => 'El whatsapp ya está siendo utilizado por otro registro.'])->withInput();
            } else if ($provider->facebook !== $request->input('facebook') && Provider::where('facebook', $request->input('facebook'))->exists()) {
                return redirect()->back()->withErrors(['facebook' => 'El facebook ya está siendo utilizado por otro registro.'])->withInput();
            }

            //actualizamos los datos
            $provider->name = $request->input('name');
            $provider->address = $request->input('address');
            $provider->phone = $request->input('phone');
            $provider->whatsapp = $request->input('whatsapp');
            $provider->facebook = $request->input('facebook');
            $provider->description = $request->input('description');

            //guardamos los cambios
            $provider->save();

            //retornamos a la vista principal
            return redirect('providers')->with('success', 'Proveedor actualizado correctamente');
        } catch (\Throwable $th) {
            try {
                // Retornamos el mensaje
                Fail::create(array(
                    'tableName' => 'providers',
                    'action' => 'update',
                    'message' => $th->getMessage(),
                    'file' => $th->getFile(),
                    'line' => $th->getLine()
                ));
                return redirect('providers')->with(array(
                    'error' => 'La acción no pudo ser realizada',
                ));
            } catch (\Throwable $th) {
                return redirect('providers')->with(array(
                    'error' => 'Error no reconocido',
                ));
            }
        }
    }

    public function destroy(Provider $provider)
    {
        $provider->delete();
        //Retornar una respuesta json
        return response()->json(array('res' => true));
    }
}
