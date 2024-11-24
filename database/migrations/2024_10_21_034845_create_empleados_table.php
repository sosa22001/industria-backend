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
        if (!Schema::hasTable('empleados')) {
            Schema::create('empleados', function (Blueprint $table) {
                $table->id();
                $table->string('dni_empleado')->unique();
                $table->string('primer_nombre');
                $table->string('segundo_nombre')->nullable();
                $table->string('primer_apellido');
                $table->string('segundo_apellido')->nullable();
                $table->unsignedBigInteger('id_puesto');
                $table->boolean('estado');
                $table->string('direccion')->nullable();
                $table->string('email')->unique();
                $table->string('telefono')->nullable();
                $table->date('fecha_nacimiento')->nullable();
                $table->date('fecha_ingreso')->nullable();
                $table->string('rtn')->nullable();
                $table->unsignedBigInteger('id_user')->nullable();
    
    
                $table->integer('created_by') ->nullable();
                $table->integer('updated_by')->nullable();
                $table->integer('deleted_by')->nullable();
                $table->timestamps();
                $table->softDeletes();
    
                $table->foreign('id_puesto')->references('id')->on('puestos')->onDelete('restrict');
                $table->foreign('id_user')->references('id')->on('users')->onDelete('restrict');
            });
        }
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empleados');
    }
};
