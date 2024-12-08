<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('ficha_producto', function (Blueprint $table) {
            $table->boolean('devuelto')->default(false)->after('fecha_vencimiento');
        });
    }

    public function down()
    {
        Schema::table('ficha_producto', function (Blueprint $table) {
            $table->dropColumn('devuelto');
        });
    }
};
