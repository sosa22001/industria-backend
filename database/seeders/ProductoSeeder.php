<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Producto;

class ProductoSeeder extends Seeder
{
    public function run(): void
    {
        // 5 registros manuales
        DB::table('productos')->insert([
            [
                'nombre_producto' => 'Televisor',
                'stock' => 20,
                'id_categoria' => 1, // ID de categoría existente
                'precio_compra' => 300.00,
                'precio_venta' => 400.00,
                'estado' => 1,
                'codigo' => 'PROD-001TV',
                'descripcion' => 'Televisor LED de 50 pulgadas',
                'id_proveedor' => 1, // ID de proveedor existente
            ],
            [
                'nombre_producto' => 'COCa Cola 2 Litros',
                'stock' => 10,
                'id_categoria' => 2,
                'precio_compra' => 150.00,
                'precio_venta' => 250.00,
                'estado' => 1,
                'codigo' => 'PROD-002SF',
                'descripcion' => 'Sofá de tres plazas color gris',
                'id_proveedor' => 2,
            ],
            [
                'nombre_producto' => 'Camiseta',
                'stock' => 50,
                'id_categoria' => 3,
                'precio_compra' => 10.00,
                'precio_venta' => 20.00,
                'estado' => 1,
                'codigo' => 'PROD-003CM',
                'descripcion' => 'Camiseta de algodón talla M',
                'id_proveedor' => 3,
            ],
            [
                'nombre_producto' => 'Bicicleta',
                'stock' => 15,
                'id_categoria' => 4,
                'precio_compra' => 200.00,
                'precio_venta' => 350.00,
                'estado' => 1,
                'codigo' => 'PROD-004BC',
                'descripcion' => 'Bicicleta de montaña color rojo',
                'id_proveedor' => 4,
            ],
            [
                'nombre_producto' => 'Laptop',
                'stock' => 30,
                'id_categoria' => 1,
                'precio_compra' => 800.00,
                'precio_venta' => 1000.00,
                'estado' => 1,
                'codigo' => 'PROD-005LT',
                'descripcion' => 'Laptop de 15 pulgadas, 8GB RAM',
                'id_proveedor' => 1,
            ],
        ]);

        // 10 registros automáticos
        Producto::factory(10)->create();
    }
}

