<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('productos', function (Blueprint $table) {
            $table->dropColumn('lote');
        });
    }

    public function down()
    {
        Schema::table('productos', function (Blueprint $table) {
            $table->string('lote')->nullable(); // Agregar la columna de nuevo si se revierte la migración
        });
    }
};