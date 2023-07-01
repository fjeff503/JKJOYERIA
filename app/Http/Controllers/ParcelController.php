<?php

namespace App\Http\Controllers;

use App\Models\Parcel;
use App\Http\Requests\Parcel\StoreParcelRequest;
use App\Http\Requests\Parcel\UpdateParcelRequest;

class ParcelController extends Controller
{
    public function index()
    {
        $parcels = Parcel::get();
        return view('admin.parcel.index', compact('parcels'));
    }

    public function create()
    {
        return view('admin.parcel.create');
    }

    public function store(StoreParcelRequest $request)
    {
        //este toma los parametros y reglas pa guardar del Http\Requests\Parcel\StoreRequest
        Parcel::create($request->all());
        return redirect()->route('parcels.index');
    }

    public function show(Parcel $parcel)
    {
        return view('admin.parcel.show', compact('parcel'));
    }

    public function edit(Parcel $parcel)
    {
        return view('admin.parcel.show', compact('parcel'));
    }

    public function update(UpdateParcelRequest $request, Parcel $parcel)
    {
        $parcel->update($request->all());
        return redirect()->route('parcels.index');
    }

    public function destroy(Parcel $parcel)
    {
        $parcel->delete();
        return redirect()->route('parcels.index');
    }
}
