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
            $table->dateTime('date')->require();
            $table->decimal('total')->require();
            $table->string('voucher');
            $table->enum('status', ['VALID', 'CANCELED'])->default('VALID');

            //relacion provider
            $table->unsignedBigInteger('idProvider');
            $table->foreign('idProvider')->references('idProvider')->on('providers');
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
        Schema::dropIfExists('purchases');
    }
};
