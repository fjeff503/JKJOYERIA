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
            $table->unsignedBigInteger('idProduct')->autoIncrement()->startingValue(100000000000);
            $table->string('codeProductProvider')->unique();
            $table->string('name')->unique();
            $table->decimal('buyPrice', 12, 2);
            $table->decimal('sellPrice', 12, 2);
            $table->integer('stock');
            $table->string('description');

            //relacion category
            $table->unsignedBigInteger('idCategory');
            $table->foreign('idCategory')->references('idCategory')->on('categories')->onUpdate('cascade');
            //relacion provider
            $table->unsignedBigInteger('idProvider');
            $table->foreign('idProvider')->references('idProvider')->on('providers')->onUpdate('cascade');

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
