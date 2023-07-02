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
        Schema::create('sale_details', function (Blueprint $table) {
            $table->id('idSaleDetails');

            $table->integer('quantity');
            $table->decimal('price');
            $table->decimal('discount');

            //relacion products
            $table->unsignedBigInteger('idProduct');
            $table->foreign('idProduct')->references('idProduct')->on('products')->onUpdate('cascade');
            //relacion sales
            $table->unsignedBigInteger('idSale');
            $table->foreign('idSale')->references('idSale')->on('sales')->onUpdate('cascade');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_details');
    }
};
