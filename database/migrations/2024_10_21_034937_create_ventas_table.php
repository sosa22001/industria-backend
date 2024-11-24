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
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->timestamp('fecha_venta'); // Fecha y hora de la venta
            $table->unsignedBigInteger('id_empleado')->nullable(); // Empleado que realizó la venta
            $table->decimal('subtotal', 10, 2); // Total sin impuestos
            $table->decimal('isv', 10, 2); // Impuesto sobre ventas
            $table->decimal('descuento', 10, 2)->default(0); // Descuento aplicado
            $table->decimal('total', 10, 2); // Total final
            $table->unsignedBigInteger('created_by')->nullable(); // Usuario que registró la venta
            $table->timestamps();
            $table->softDeletes();

            // Relaciones
            $table->foreign('id_empleado')->references('id')->on('empleados')->onDelete('restrict');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ventas');
    }
};
