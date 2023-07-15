<?php

namespace App\Http\Controllers;

use App\Models\Fail;
use App\Models\Client;
use Illuminate\Http\Request;
use App\Http\Requests\Client\StoreClientRequest;
use App\Http\Requests\Client\UpdateClientRequest;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        //Extraemos los clientes
        $data = Client::all();

        return view('/admin/client/index', compact('data'));
    }

    public function create()
    {
        return view('/admin/client/create');
    }

    public function store(StoreClientRequest $request)
    {
        try {
            // Validamos la data
            $validatedData = $request->validated();

            // Verificar si ya existe un cliente con el mismo telefono (incluyendo las eliminadas lógicamente)
            $existingPhone = Client::withTrashed()->where('phone', $validatedData['phone'])->first();
            // Verificar si ya existe un cliente con el mismo telefono (incluyendo las eliminadas lógicamente)
            $existingWhatsapp = Client::withTrashed()->where('whatsapp', $validatedData['whatsapp'])->first();

            //para Telefono
            if ($existingPhone) {
                // Si ya existe un cliente con el mismo telefono, verifica si está eliminada lógicamente
                if ($existingPhone->trashed() != null) {
                    // Restaurar el cliente eliminado lógicamente
                    $existingPhone->restore();
                    return redirect('clients')->with('info', 'Cliente restaurado correctamente');
                } else {
                    // Si el cliente no está eliminado lógicamente, muestra un mensaje de error
                    return redirect()->back()->withErrors('El numero de teléfono ya está en uso');
                }
            }

            //para Whatsapp
            if ($existingWhatsapp) {
                // Si ya existe un cliente con el mismo telefono, verifica si está eliminada lógicamente
                if ($existingWhatsapp->trashed() != null) {
                    // Restaurar el cliente eliminado lógicamente
                    $existingWhatsapp->restore();
                    return redirect('clients')->with('info', 'Cliente restaurado correctamente');
                } else {
                    // Si el cliente no está eliminado lógicamente, muestra un mensaje de error
                    return redirect()->back()->withErrors('El numero de teléfono ya está en uso');
                }
            }

            // Si no existe un cliente con el mismo nombre, crea un nuevo cliente
            Client::create($validatedData);

            return redirect('clients')->with('success', 'Cliente creado correctamente');
        } catch (\Throwable $th) {
            try {
                // Retornamos el mensaje
                Fail::create(array(
                    'tableName' => 'clients',
                    'action' => 'store',
                    'message' => $th->getMessage(),
                    'file' => $th->getFile(),
                    'line' => $th->getLine()
                ));
                return redirect('clients')->with(array(
                    'error' => 'La acción no pudo ser realizada',
                ));
            } catch (\Throwable $th) {
                return redirect('clients')->with(array(
                    'error' => 'Error no reconocido',
                ));
            }
        }
    }

    public function edit(Client $client)
    {
        //Mostrar la vista 
        return view('/admin/client/update')->with(['client' => $client]);
    }

    public function update(UpdateClientRequest $request, $idClient)
    {
        //intento
        try {
            //traemos la data si el iteme que estamos modificando
            $client = Client::findOrFail($idClient);

            // Verificar si el nuevo valor del campo "telefono" ya existe en otro registro
            if ($client->phone !== $request->input('phone') && Client::where('phone', $request->input('phone'))->exists()) {
                return redirect()->back()->withErrors(['phone' => 'El teléfono ya está siendo utilizado por otro registro.'])->withInput();
            } else if ($client->whatsapp !== $request->input('whatsapp') && Client::where('whatsapp', $request->input('whatsapp'))->exists()) {
                return redirect()->back()->withErrors(['whatsapp' => 'El whatsapp ya está siendo utilizado por otro registro.'])->withInput();
            }

            //actualizamos los datos
            $client->name = $request->input('name');
            $client->phone = $request->input('phone');
            $client->whatsapp = $request->input('whatsapp');

            //guardamos los cambios
            $client->save();

            //retornamos a la vista principal
            return redirect('clients')->with('success', 'Cliente actualizado correctamente');
        } catch (\Throwable $th) {
            try {
                // Retornamos el mensaje
                Fail::create(array(
                    'tableName' => 'clients',
                    'action' => 'update',
                    'message' => $th->getMessage(),
                    'file' => $th->getFile(),
                    'line' => $th->getLine()
                ));
                return redirect('clients')->with(array(
                    'error' => 'La acción no pudo ser realizada',
                ));
            } catch (\Throwable $th) {
                return redirect('categories')->with(array(
                    'error' => 'Error no reconocido',
                ));
            }
        }
    }

    public function destroy(Client $client)
    {
        $client->delete();
        //Retornar una respuesta json
        return response()->json(array('res' => true));
    }
}
