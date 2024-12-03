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
        Schema::table('fichas_inventario', function (Blueprint $table) {
            $table->enum('estado', ['pendiente', 'procesado', 'recibido', 'cancelado', 'rechazado'])->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fichas_inventario', function (Blueprint $table) {
            $table->enum('estado', ['pendiente', 'procesado', 'recibido', 'cancelado'])->change();
        });
    }
};
