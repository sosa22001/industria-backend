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
        Schema::create('fichas_inventario', function (Blueprint $table) {
            $table->id(); // ID único de la ficha
            $table->foreignId('proveedor_id')->constrained('proveedores')->onDelete('cascade'); // Relación con proveedores
            $table->enum('tipo_movimiento', ['pedido', 'compra_directa', 'devolucion', 'ajuste']); // Tipo de ficha
            $table->enum('estado', ['pendiente', 'procesado', 'recibido', 'cancelado'])->default('pendiente'); // Estado
            $table->date('fecha_pedido')->nullable(); // Fecha del pedido
            $table->date('fecha_recepcion')->nullable(); // Fecha esperada de recepción
            $table->text('comentarios')->nullable(); // Observaciones o notas
            $table->timestamps(); // created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fichas_inventario');
    }
};
