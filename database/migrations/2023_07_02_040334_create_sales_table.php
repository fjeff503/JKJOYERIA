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
            $table->string('packageState');
            $table->string('paymentState');
            $table->enum('status', ['VALID', 'CANCELED'])->default('VALID');
            $table->string('description')->nullable();

            //relacion client
            $table->unsignedBigInteger('idClient');
            $table->foreign('idClient')->references('idClient')->on('clients');
            //relacion deliveryPoint
            $table->unsignedBigInteger('idDeliveryPoint');
            $table->foreign('idDeliveryPoint')->references('idDeliveryPoint')->on('delivery_points');
            //relacion user
            $table->unsignedBigInteger('idUser');
            $table->foreign('idUser')->references('id')->on('users');

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