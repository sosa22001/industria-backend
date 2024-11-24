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
        Schema::create('detalle_ventas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('venta_id'); // Relación con la venta
            $table->unsignedBigInteger('producto_id'); // Relación con el producto
            $table->integer('cantidad'); // Cantidad vendida
            $table->decimal('precio_unitario', 10, 2); // Precio por unidad
            $table->decimal('subtotal', 10, 2); // Subtotal por producto
            $table->timestamps();

            // Relaciones
            $table->foreign('venta_id')->references('id')->on('ventas')->onDelete('cascade');
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_ventas');
    }
};
