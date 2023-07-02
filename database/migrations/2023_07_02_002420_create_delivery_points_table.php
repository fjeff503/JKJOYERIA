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
        Schema::create('delivery_points', function (Blueprint $table) {
            $table->id('idDeliveryPoint');
            $table->string('name');
            $table->string('hour');
            $table->string('description')->nullable();
            $table->enum('status', ['ACTIVE', 'DEACTIVED'])->default('ACTIVE');

            //relacion parcel
            $table->unsignedBigInteger('idParcel');
            $table->foreign('idParcel')->references('idParcel')->on('parcels')->onUpdate('cascade');

            //relacion day
            $table->unsignedBigInteger('idDay');
            $table->foreign('idDay')->references('idDay')->on('days')->onUpdate('cascade');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_points');
    }
};
