<?php

namespace App\Http\Controllers;

use App\Models\paymentState;
use App\Http\Requests\PaymentState\StorepaymentStateRequest;
use App\Http\Requests\PaymentState\UpdatepaymentStateRequest;

class PaymentStateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorepaymentStateRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(paymentState $paymentState)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(paymentState $paymentState)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatepaymentStateRequest $request, paymentState $paymentState)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(paymentState $paymentState)
    {
        //
    }
}
