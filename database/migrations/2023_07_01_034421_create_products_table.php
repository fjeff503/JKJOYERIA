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
        Schema::create('products', function (Blueprint $table) {
            $table->id('idProduct');
            $table->string('codeProduct')->unique();
            $table->string('codeProductProvider')->unique();
            $table->string('name')->unique();
            $table->decimal('sellPrice', 12, 2);
            $table->integer('stock');
            $table->enum('status', ['ACTIVE', 'DEACTIVED'])->default('ACTIVE');
            $table->string('description');

            //relacion category
            $table->unsignedBigInteger('idCategory');
            $table->foreign('idCategory')->references('idCategory')->on('categories');
            //relacion provider
            $table->unsignedBigInteger('idProvider');
            $table->foreign('idProvider')->references('idProvider')->on('providers');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
