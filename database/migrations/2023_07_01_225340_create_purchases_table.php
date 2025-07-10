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
        Schema::create('purchases', function (Blueprint $table) {
            $table->id('idPurchase');
            $table->decimal('total')->require();
            $table->string('voucher')->nullable();

            //relacion provider
            $table->unsignedBigInteger('idProvider');
            $table->foreign('idProvider')->references('idProvider')->on('providers')->onUpdate('cascade');
            
            //relacion user
            $table->unsignedBigInteger('idUser');
            $table->foreign('idUser')->references('id')->on('users')->onUpdate('cascade');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
