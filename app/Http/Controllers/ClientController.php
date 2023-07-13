<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Http\Requests\Client\StoreClientRequest;
use App\Http\Requests\Client\UpdateClientRequest;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index(Request $request)
    {
       //Extraemos los clientes
       $clients = Client :: all();

       return view('/admin/client/index', compact('clients'));
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
    
        if ($existingPhone or $existingWhatsapp) {
            // Si ya existe un cliente con el mismo telefono, verifica si está eliminada lógicamente
            if ($existingPhone->trashed() and $existingWhatsapp->trashed()) {
                // Restaurar el cliente eliminado lógicamente
                $existingPhone->restore();
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
            
            return redirect('clients')->with('error', 'La acción no pudo ser realizada');
        }
    }

    public function edit(Client $client)
    {
       //Mostrar la vista 
       return view('/admin/client/update')->with(['client' => $client]);
    }

    public function update(UpdateClientRequest $request, $idClient)
    {
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
    }

    public function destroy(Client $client)
    {
        $client->delete();
        //Retornar una respuesta json
        return response()->json(array('res' => true));;
    }
}
