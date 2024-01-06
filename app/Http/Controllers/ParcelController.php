<?php

namespace App\Http\Controllers;

use App\Models\Parcel;
use App\Models\Fail;
use Illuminate\Http\Request;
use App\Http\Requests\Parcel\StoreParcelRequest;
use App\Http\Requests\Parcel\UpdateParcelRequest;


class ParcelController extends Controller
{
    public function index(Request $request)
    {
        //Extraemos los clientes
        $parcels = Parcel::all();

        return view('/admin/parcel/index', compact('parcels'));
    }

    public function create()
    {
        return view('admin.parcel.create');
    }

    public function store(StoreParcelRequest $request)
    {
        try {
            // Validamos la data
            $validatedData = $request->validated();

            // Verificar si ya existe un encomendista con el mismo telefono (incluyendo las eliminadas lógicamente)
            $existingPhone = Parcel::withTrashed()->where('phone', $validatedData['phone'])->first();
            // Verificar si ya existe un encomendista con el mismo whatsapp (incluyendo las eliminadas lógicamente)
            $existingWhatsapp = Parcel::withTrashed()->where('whatsapp', $validatedData['whatsapp'])->first();
            // Verificar si ya existe un encomendista con el mismo facebook (incluyendo las eliminadas lógicamente)
            $existingFacebook = Parcel::withTrashed()->where('facebook', $validatedData['facebook'])->first();
            // Verificar si ya existe un encomendista con el mismo telefono (incluyendo las eliminadas lógicamente)
            $existingName = Parcel::withTrashed()->where('name', $validatedData['name'])->first();

            //para Nombre
            if ($existingName) {
                // Si ya existe un encomendista con el mismo telefono, verifica si está eliminada lógicamente
                if ($existingName->trashed() != null) {
                    // Restaurar el encomendista eliminado lógicamente
                    $existingName->restore();
                    return redirect('parcels')->with('info', 'Encomendista restaurado correctamente');
                }
            }

            //para Telefono
            if ($existingPhone) {
                // Si ya existe un encomendista con el mismo telefono, verifica si está eliminada lógicamente
                if ($existingPhone->trashed() != null) {
                    // Restaurar el encomendista eliminado lógicamente
                    $existingPhone->restore();
                    return redirect('parcels')->with('info', 'Encomendista restaurado correctamente');
                }
            }

            //para Whatsapp
            if ($existingWhatsapp) {
                // Si ya existe un encomendista con el mismo telefono, verifica si está eliminada lógicamente
                if ($existingWhatsapp->trashed() != null) {
                    // Restaurar el encomendista eliminado lógicamente
                    $existingWhatsapp->restore();
                    return redirect('parcels')->with('info', 'Encomendista restaurado correctamente');
                }
            }

            //para Facebook
            if ($existingFacebook) {
                // Si ya existe un encomendista con el mismo telefono, verifica si está eliminada lógicamente
                if ($existingFacebook->trashed() != null) {
                    // Restaurar el encomendista eliminado lógicamente
                    $existingFacebook->restore();
                    return redirect('parcels')->with('info', 'Encomendista restaurado correctamente');
                }
            }

            // Si no existe un encomendista con el mismo nombre, crea un nuevo encomendista
            Parcel::create($validatedData);

            return redirect('parcels')->with('success', 'Encomendista creado correctamente');
        } catch (\Throwable $th) {
            try {
                // Retornamos el mensaje
                Fail::create(array(
                    'tableName' => 'parcels',
                    'action' => 'store',
                    'message' => $th->getMessage(),
                    'file' => $th->getFile(),
                    'line' => $th->getLine()
                ));
                return redirect('parcels')->with(array(
                    'error' => 'La acción no pudo ser realizada',
                ));
            } catch (\Throwable $th) {
                return redirect('parcels')->with(array(
                    'error' => 'Error no reconocido',
                ));
            }
        }
    }

    public function edit(Parcel $parcel)
    {
        //Mostrar la vista 
        return view('/admin/parcel/update')->with(['parcel' => $parcel]);
    }

    public function update(UpdateParcelRequest $request, $idParcel)
    {
        //intento
        try {
            //traemos la data si el iteme que estamos modificando
            $parcel = Parcel::findOrFail($idParcel);

            // Verificar si el nuevo valor del campo "telefono" ya existe en otro registro
            if ($parcel->phone !== $request->input('phone') && Parcel::where('phone', $request->input('phone'))->exists()) {
                return redirect()->back()->withErrors(['phone' => 'El teléfono ya está siendo utilizado por otro registro.'])->withInput();
            } else if ($parcel->whatsapp !== $request->input('whatsapp') && Parcel::where('whatsapp', $request->input('whatsapp'))->exists()) {
                return redirect()->back()->withErrors(['whatsapp' => 'El whatsapp ya está siendo utilizado por otro registro.'])->withInput();
            }

            //actualizamos los datos
            $parcel->name = $request->input('name');
            $parcel->phone = $request->input('phone');
            $parcel->whatsapp = $request->input('whatsapp');

            //guardamos los cambios
            $parcel->save();

            //retornamos a la vista principal
            return redirect('parcels')->with('success', 'Encomendista actualizado correctamente');
        } catch (\Throwable $th) {
            try {
                // Retornamos el mensaje
                Fail::create(array(
                    'tableName' => 'parcels',
                    'action' => 'update',
                    'message' => $th->getMessage(),
                    'file' => $th->getFile(),
                    'line' => $th->getLine()
                ));
                return redirect('parcels')->with(array(
                    'error' => 'La acción no pudo ser realizada',
                ));
            } catch (\Throwable $th) {
                return redirect('parcels')->with(array(
                    'error' => 'Error no reconocido',
                ));
            }
        }
    }

    public function destroy(Parcel $parcel)
    {
        $parcel->delete();
        //Retornar una respuesta json
        return response()->json(array('res' => true));
    }
}
