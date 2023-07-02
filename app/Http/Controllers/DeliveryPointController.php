<?php

namespace App\Http\Controllers;

use App\Models\DeliveryPoint;
use App\Http\Requests\DeliveryPoint\StoreDeliveryPointRequest;
use App\Http\Requests\DeliveryPoint\UpdateDeliveryPointRequest;
use App\Models\Day;
use App\Models\Parcel;

class DeliveryPointController extends Controller
{
    public function index()
    {
        $deliveryPoints = DeliveryPoint::get();
        return view('admin.deliveryPoint.index', compact('deliveryPoints'));
    }

    public function create()
    {
        $parcels = Parcel::get();
        $days = Day::get();
        return view('admin.deliveryPoint.create', compact('parcels', 'days'));
    }

    public function store(StoreDeliveryPointRequest $request)
    {
        //este toma los parametros y reglas pa guardar del Http\Requests\DeliveryPoint\StoreDeliveryPointRequest
        DeliveryPoint::create($request->all());
        return redirect()->route('deliveryPoints.index');
    }

    public function show(DeliveryPoint $deliveryPoint)
    {
        return view('admin.deliveryPoint.show', compact('deliveryPoint'));
    }

    public function edit(DeliveryPoint $deliveryPoint)
    {
        $parcels = Parcel::get();
        $days = Day::get();
        return view('admin.deliveryPoint.show', compact('deliveryPoint', 'parcels', 'days'));
    }

    public function update(UpdateDeliveryPointRequest $request, DeliveryPoint $deliveryPoint)
    {
        $deliveryPoint->update($request->all());
        return redirect()->route('deliveryPoints.index');
    }

    public function destroy(DeliveryPoint $deliveryPoint)
    {
        $deliveryPoint->delete();
        return redirect()->route('deliveryPoints.index');
    }
}
