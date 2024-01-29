<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Http\Requests\Sale\StoreSaleRequest;
use App\Http\Requests\Sale\UpdateSaleRequest;
use App\Models\Client;
use App\Models\packageState;
use App\Models\paymentState;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::get();
        return view('admin.sale.index', compact('sales'));
    }

    public function create()
    {
        $clients = Client::get();
        $packageStates = packageState::get();
        $paymentStates = paymentState::get();
        return view('admin.sale.create', compact('clients', 'packageStates', 'paymentStates'));
    }

    public function store(StoreSaleRequest $request)
    {
        //este toma los parametros y reglas pa guardar del Http\Requests\Sale\StoreSaleRequest
        $sale = Sale::create($request->all());

        foreach ($request->idProduct as $key => $product) {
            $results[] = array(
                "idProduct" => $request->idProduct[$key],
                "discount" => $request->discount[$key],
                "quantity" => $request->quantity[$key],
                "price" => $request->price[$key]
            );
        };

        $sale->saleDetails()->createMany($results);

        return redirect()->route('sales.index');
    }

    public function show(Sale $sale)
    {
        return view('admin.sale.show', compact('sale'));
    }

    public function edit(Sale $sale)
    {
        $clients = Client::get();
        $packageStates = packageState::get();
        $paymentStates = paymentState::get();
        return view('admin.sale.show', compact('sale', 'clients', 'packageStates', 'paymentStates'));
    }

    public function update(UpdateSaleRequest $request, Sale $sale)
    {
        $sale->update($request->all());
        return redirect()->route('sales.index');
    }

    public function destroy(Sale $sale)
    {
        $sale->delete();
        return redirect()->route('sales.index');
    }
}
