<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Http\Requests\Purchase\StorePurchaseRequest;
use App\Http\Requests\Purchase\UpdatePurchaseRequest;
use App\Models\Provider;

class PurchaseController extends Controller
{
    public function index()
    {
        $purchases = Purchase::get();
        return view('admin.purchase.index', compact('purchases'));
    }

    public function create()
    {
        $providers = Provider::get();
        return view('admin.purchase.create', compact('providers'));
    }

    public function store(StorePurchaseRequest $request)
    {
        //este toma los parametros y reglas pa guardar del Http\Requests\Provider\StoreProviderRequest
        $purchase = Purchase::create($request->all());

        foreach($request->idProduct as $key => $product){
            $results[] = array("idProduct"=>$request->idProduct[$key], 
                                "quantity"=>$request->quantity[$key], 
                                "price"=>$request->price[$key]);
        };

        $purchase->purchaseDetails()->createMany($results);

        return redirect()->route('purchases.index');
    }

    public function show(Purchase $provider)
    {
        return view('admin.purchase.show', compact('purchase'));
    }

    public function edit(Purchase $provider)
    {
        $providers = Provider::get();
        return view('admin.purchase.show', compact('purchase', 'providers'));
    }

    public function update(UpdatePurchaseRequest $request, Purchase $purchase)
    {
        $purchase->update($request->all());
        return redirect()->route('purchases.index');
    }

    public function destroy(Purchase $purchase)
    {
        $purchase->delete();
        return redirect()->route('purchases.index');
    }
}
