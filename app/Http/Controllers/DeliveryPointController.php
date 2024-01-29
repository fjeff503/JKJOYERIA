<?php

namespace App\Http\Controllers;

use App\Models\DeliveryPoint;
use App\Http\Requests\DeliveryPoint\StoreDeliveryPointRequest;
use App\Http\Requests\DeliveryPoint\UpdateDeliveryPointRequest;
use App\Models\Day;
use App\Models\Parcel;
use App\Models\Fail;
use Illuminate\Http\Request;

class DeliveryPointController extends Controller
{
    public function index()
    {
        //Extraemos las Categorias
        $data = DeliveryPoint::select(
            "delivery_points.idDeliveryPoint",
            "delivery_points.name",
            "delivery_points.hour",
            "delivery_points.description",
            "parcels.name as parcel",
            "days.name as day"
        )
            ->join("days", "days.idDay", "=", "delivery_points.idDay")
            ->join("parcels", "parcels.idParcel", "=", "delivery_points.idParcel")
            ->get();

        return view('/admin/delivery_point/index')->with(['data' => $data]);
    }

    public function create()
    {
        //extraemos los punto
        $parcels = Parcel::get();
        //extraemos los dias 
        $days = Day::get();

        return view('/admin/delivery_point/create', compact('parcels', 'days'));
    }

    public function store(StoreDeliveryPointRequest $request)
    {
        try {
            // Validamos la data
            $validatedData = $request->validated();

            // Verificar si ya existe un DeliveryPoint con el mismo nombre, idDay, e idParcel
            $existingDeliveryPoint = DeliveryPoint::withTrashed()
                ->where('name', $validatedData['name'])
                ->where('idDay', $validatedData['idDay'])
                ->where('idParcel', $validatedData['idParcel'])
                ->first();

            if ($existingDeliveryPoint) {
                // Si ya existe un DeliveryPoint con el mismo nombre, idDay, e idParcel, verifica si está eliminado lógicamente
                if ($existingDeliveryPoint->trashed() != null) {
                    // Restaurar el DeliveryPoint eliminado lógicamente
                    $existingDeliveryPoint->restore();
                    return redirect('delivery_points')->with('info', 'Punto de entrega restaurado correctamente');
                }
            }

            // Si no existe un encomendista con el mismo nombre, crea un nuevo Punto de Entrega
            DeliveryPoint::create($validatedData);

            return redirect('delivery_points')->with('success', 'Punto de Entrega creado correctamente');
        } catch (\Throwable $th) {
            try {
                // Retornamos el mensaje
                Fail::create(array(
                    'tableName' => 'delivery_points',
                    'action' => 'store',
                    'message' => $th->getMessage(),
                    'file' => $th->getFile(),
                    'line' => $th->getLine()
                ));
                return redirect('delivery_points')->with(array(
                    'error' => 'La acción no pudo ser realizada',
                ));
            } catch (\Throwable $th) {
                return redirect('delivery_points')->with(array(
                    'error' => 'Error no reconocido',
                ));
            }
        }
    }


    public function edit(DeliveryPoint $deliveryPoint)
    {
        //extraemos los encomendistas
        $parcels = Parcel::get();
        //extraemos los dias 
        $days = Day::get();

        return view('/admin/delivery_point/update', compact('deliveryPoint', 'parcels', 'days'));
    }

    public function update(UpdateDeliveryPointRequest $request, $idDeliveryPoint)
    {
        //intento
        try {
            // Traemos la data del item que estamos modificando
            $deliveryPoint = DeliveryPoint::findOrFail($idDeliveryPoint);
            // Verificar si el nuevo valor del campo "name, parcel y day" ya existe en otro registro con el mismo idParcel e idDay
            if (($deliveryPoint->name != $request->input('name')
                    || $deliveryPoint->idDay != $request->input('idDay')
                    || $deliveryPoint->idParcel != $request->input('idParcel')) &&
                DeliveryPoint::where('name', $request->input('name'))
                ->where('idParcel', $request->input('idParcel'))
                ->where('idDay', $request->input('idDay'))
                ->exists()
            ) {
                return redirect()->back()->withErrors(['name' => 'El Punto de Entrega ya está siendo utilizado por otro registro.'])->withInput();
            }

            // Actualizamos los datos
            $deliveryPoint->name = $request->input('name');
            $deliveryPoint->hour = $request->input('hour');
            $deliveryPoint->description = $request->input('description');
            $deliveryPoint->idParcel = $request->input('idParcel');
            $deliveryPoint->idDay = $request->input('idDay');
            // Guardamos los cambios
            $deliveryPoint->save();

            // Retornamos a la vista principal
            return redirect('delivery_points')->with('success', 'Punto de Entrega actualizado correctamente');
        } catch (\Throwable $th) {
            try {
                // Retornamos el mensaje
                Fail::create(array(
                    'tableName' => 'delivery_points',
                    'action' => 'update',
                    'message' => $th->getMessage(),
                    'file' => $th->getFile(),
                    'line' => $th->getLine()
                ));
                return redirect('delivery_points')->with(array(
                    'error' => 'La acción no pudo ser realizada',
                ));
            } catch (\Throwable $th) {
                return redirect('delivery_points')->with(array(
                    'error' => 'Error no reconocido',
                ));
            }
        }
    }

    public function destroy(DeliveryPoint $deliveryPoint)
    {
        $deliveryPoint->delete();
        //Retornar una respuesta json
        return response()->json(array('res' => true));
    }
}
