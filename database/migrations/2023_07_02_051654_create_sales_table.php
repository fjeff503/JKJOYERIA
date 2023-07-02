<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id('idSale');

            $table->dateTime('date')->require();
            $table->decimal('total')->require();
            $table->enum('status', ['VALID', 'CANCELED'])->default('VALID');
            $table->string('description')->nullable();

            //relacion client
            $table->unsignedBigInteger('idClient');
            $table->foreign('idClient')->references('idClient')->on('clients')->onUpdate('cascade');
            //relacion user
            $table->unsignedBigInteger('idUser');
            $table->foreign('idUser')->references('id')->on('users')->onUpdate('cascade');
            //relacion deliveryPoint
            $table->unsignedBigInteger('idDeliveryPoint');
            $table->foreign('idDeliveryPoint')->references('idDeliveryPoint')->on('delivery_points')->onUpdate('cascade');
            //relacion package_state
            $table->unsignedBigInteger('packageState');
            $table->foreign('packageState')->references('idPackageState')->on('package_states')->onUpdate('cascade');
            ///relacion payment_state
            $table->unsignedBigInteger('paymentState');
            $table->foreign('paymentState')->references('idPaymentState')->on('payment_states')->onUpdate('cascade');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
