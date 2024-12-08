<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('ficha_producto', function (Blueprint $table) {
            $table->dropColumn('fecha_vencimiento');
        });
    }

    public function down()
    {
        Schema::table('ficha_producto', function (Blueprint $table) {
            $table->date('fecha_vencimiento')->nullable(); // Agregarla de nuevo si se revierte la migración
        });
    }
    
};
