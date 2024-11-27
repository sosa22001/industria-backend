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
        Schema::create('ficha_producto', function (Blueprint $table) {
            $table->id(); // ID único de la relación
            $table->foreignId('ficha_inventario_id')->constrained('fichas_inventario')->onDelete('cascade'); // Relación con fichas de inventario
            $table->foreignId('producto_id')->constrained('productos')->onDelete('cascade'); // Relación con productos
            $table->integer('cantidad'); // Cantidad del producto
            $table->decimal('precio_compra', 10, 2); // Precio de compra
            $table->string('lote')->nullable(); // Lote del producto
            $table->date('fecha_vencimiento')->nullable(); // Fecha de vencimiento
            $table->timestamps(); // created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ficha_producto');
    }
};
