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
        Schema::create('fails', function (Blueprint $table) {
            $table->id('idFail');
            $table->string('tableName');
            $table->string('action');
            $table->string('message');
            $table->string('file');
            $table->string('line');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fails');
    }
};
