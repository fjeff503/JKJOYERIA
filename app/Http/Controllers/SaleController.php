<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Http\Requests\Sale\StoreSaleRequest;
use App\Http\Requests\Sale\UpdateSaleRequest;
use App\Models\Client;
use App\Models\DeliveryPoint;
use App\Models\packageState;
use App\Models\paymentState;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public function index()
    {
        //Extraemos las Compras
        $data = Sale::select(
            'sales.idSale',
            DB::raw("DATE_FORMAT(sales.created_at, '%d/%m/%Y %H:%i') as date"),
            'sales.total',
            'sales.description',
            'clients.name as client',
            'delivery_points.name as delivery_point',
            'package_states.name as package_state',
            'payment_states.name as payment_state',
            'users.name as user',
            
        )
            ->join('clients', 'clients.idClient', '=', 'sales.idClient')
            ->join('delivery_points', 'delivery_points.idDeliveryPoint', '=', 'sales.idDeliveryPoint')
            ->join('package_states', 'package_states.idPackageState', '=', 'sales.idPackageState')
            ->join('payment_states', 'payment_states.idPaymentState', '=', 'sales.idPaymentState')
            ->join('users', 'users.id', '=', 'sales.idUser')
            ->get();
        
            return view('/sale/index')->with(['data' => $data]);
    }

    public function create()
    {
        //extraemos los clientes
        $clients = Client::get();

        //extraemos los puntos de entrega
        $delivery_points = DeliveryPoint::get();

        //extraemos los estados de paquetes
        $package_states = packageState::get();

        //extraemos los estados de pago
        $payment_states = paymentState::get();

        return view('/sale/create', compact('clients', 'delivery_points', 'package_states', 'payment_states'));
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
