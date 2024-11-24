<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Categoria;

class CategoriaSeeder extends Seeder
{
    public function run(): void
    {
        // 5 registros manuales
        DB::table('categorias')->insert([
            [
                'nombre_categoria' => 'Electrónica',
                'descripcion_categoria' => 'Dispositivos electrónicos y accesorios',
                'created_by' => 1,
                'updated_by' => null,
            ],
            [
                'nombre_categoria' => 'bebidas',
                'descripcion_categoria' => 'Bebidas Carbonatadas',
                'created_by' => 1,
                'updated_by' => null,
            ],
            [
                'nombre_categoria' => 'Hogar',
                'descripcion_categoria' => 'Artículos para el hogar y muebles',
                'created_by' => 1,
                'updated_by' => null,
            ],
            [
                'nombre_categoria' => 'Deportes',
                'descripcion_categoria' => 'Equipo y ropa deportiva',
                'created_by' => 2,
                'updated_by' => null,
            ],
            [
                'nombre_categoria' => 'Alimentos',
                'descripcion_categoria' => 'Comida y productos perecederos',
                'created_by' => 2,
                'updated_by' => null,
            ],
        ]);

        // 10 registros automáticos
        Categoria::factory(10)->create();
    }
}

