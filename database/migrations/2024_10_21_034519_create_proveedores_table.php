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
        // Verificar si la tabla no existe antes de crearla
        if (!Schema::hasTable('proveedores')) {
            Schema::create('proveedores', function (Blueprint $table) {
                $table->id();
                $table->string('nombre_proveedor');
                $table->string('email');
                $table->string('telefono');
                $table->boolean('estado');
                $table->string('direccion');
                $table->integer('created_by')->nullable();
                $table->integer('updated_by')->nullable();
                $table->integer('deleted_by')->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proveedores');
    }
};

