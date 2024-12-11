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
                'nombre_producto' => 'Azucar 1 Libra ',
                'stock' => 200,
                'id_categoria' => 1, // ID de categoría existente
                'precio_compra' => 5.00,
                'precio_venta' => 15.00,
                'estado' => 1,
                'codigo' => 'PROD-001loTV',
                'descripcion' => 'Azucar Blanca',
                'id_proveedor' => 1, // ID de proveedor existente
            ],
            [
                'nombre_producto' => 'COCA COLA 2 Litros',
                'stock' => 150,
                'id_categoria' => 2,
                'precio_compra' => 40.00,
                'precio_venta' => 50.00,
                'estado' => 1,
                'codigo' => 'PROD-002LSolF',
                'descripcion' => 'Coca Cola 2 Litros',
                'id_proveedor' => 2,
            ],
            [
                'nombre_producto' => 'COCA COLA 1.25 Litros',
                'stock' => 500,
                'id_categoria' => 2,
                'precio_compra' => 15.00,
                'precio_venta' => 27.00,
                'estado' => 1,
                'codigo' => 'PROD-00K23CM',
                'descripcion' => 'COCA COLA 1.25 Litros',
                'id_proveedor' => 3,
            ],
            [
                'nombre_producto' => ' Detergente  ',
                'stock' => 200,
                'id_categoria' => 4,
                'precio_compra' => 5.00,
                'precio_venta' => 10.00,
                'estado' => 1,
                'codigo' => 'PROD-004LJBC',
                'descripcion' => 'dETEGENTE',
                'id_proveedor' => 1,
            ],
            [
                'nombre_producto' => 'Jamón 1 Libra',
                'stock' => 70,
                'id_categoria' => 4,
                'precio_compra' => 20.00,
                'precio_venta' => 30.00,
                'estado' => 1,
                'codigo' => 'PROD-005GJloLT',
                'descripcion' => 'Laptop de 15 pulgadas, 8GB RAM',
                'id_proveedor' => 1,
            ],
            [
                'nombre_producto' => 'Jabon ',
                'stock' => 100,
                'id_categoria' => 3,
                'precio_compra' => 10.00,
                'precio_venta' => 20.00,
                'estado' => 1,
                'codigo' => 'PROD-006SolFGLT',
                'descripcion' => 'Leche entera',
                'id_proveedor' => 2,
            ],
            [
                'nombre_producto' => 'Sal 1 Libra',
                'stock' => 200,
                'id_categoria' => 5,
                'precio_compra' => 5.00,
                'precio_venta' => 10.00,
                'estado' => 1,
                'codigo' => 'PROD-007KolMNBC',
                'descripcion' => 'Sal Fina',
                'id_proveedor' => 3,

            ],
            [
                'nombre_producto' => 'aceite 1 Litro',
                'stock' => 500,
                'id_categoria' => 5,
                'precio_compra' => 10.00,
                'precio_venta' => 20.00,
                'estado' => 1,
                'codigo' => 'PROD-003loCM',
                'descripcion' => 'Aceite de cocina',
                'id_proveedor' => 3,
            ],
            [
                'nombre_producto' => 'Carne de Res 1 Libra',
                'stock' => 200,
                'id_categoria' => 4,
                'precio_compra' => 30.00,
                'precio_venta' => 50.00,
                'estado' => 1,
                'codigo' => 'PROD-004ollBC',
                'descripcion' => 'Carne de Res',
                'id_proveedor' => 4,
            ],
            [
                'nombre_producto' => 'Carne de Cerdo 1 Libra',
                'stock' => 70,
                'id_categoria' => 4,
                'precio_compra' => 10.00,
                'precio_venta' => 20.00,
                'estado' => 1,
                'codigo' => 'PROD-005KLMNHLT',
                'descripcion' => 'Carne de Cerdo',
                'id_proveedor' => 1,
            ],
            [
                'nombre_producto' => 'Leche 1 Litro',
                'stock' => 100,
                'id_categoria' => 2,
                'precio_compra' => 10.00,
                'precio_venta' => 20.00,
                'estado' => 1,
                'codigo' => 'PROD-006olLT',
                'descripcion' => 'Leche entera',
                'id_proveedor' => 2,
            ],
            [
                'nombre_producto' => 'Frijoles 1 Libra',
                'stock' => 200,
                'id_categoria' => 1,
                'precio_compra' => 5.00,
                'precio_venta' => 10.00,
                'estado' => 1,
                'codigo' => 'PROD-00lo7BC',
                'descripcion' => 'F',
                'id_proveedor' => 3,

            ],
            [
                'nombre_producto' => 'Huevos 1 Docena',
                'stock' => 500,
                'id_categoria' => 1,
                'precio_compra' => 50.00,
                'precio_venta' => 70.00,
                'estado' => 1,
                'codigo' => 'PROD-003LoNMJCM',
                'descripcion' => 'Arroz Blanco',
                'id_proveedor' => 4,

            ],
            [
                'nombre_producto' => 'Arroz 2 Libra',
                'stock' => 200,
                'id_categoria' => 1,
                'precio_compra' => 5.00,
                'precio_venta' => 10.00,
                'estado' => 1,
                'codigo' => 'PROD-004BloC',
                'descripcion' => 'Arroz Blanco',
                'id_proveedor' => 5,
            ],
            [
                'nombre_producto' => 'Papas 1 Libra',
                'stock' => 70,
                'id_categoria' => 4,
                'precio_compra' => 20.00,
                'precio_venta' => 30.00,
                'estado' => 1,
                'codigo' => 'PROD-005GlJLT',
                'descripcion' => 'Papas',
                'id_proveedor' => 4,
            ],
            [
                'nombre_producto' => 'Cebolla 1 Libra',
                'stock' => 100,
                'id_categoria' => 3,
                'precio_compra' => 10.00,
                'precio_venta' => 20.00,
                'estado' => 1,
                'codigo' => 'PROD-006SlFGpLT',
                'descripcion' => 'Cebolla',
                'id_proveedor' => 4,
            ],
            [
                'nombre_producto' => 'Tomate 1 Libra',
                'stock' => 200,
                'id_categoria' => 5,
                'precio_compra' => 5.00,
                'precio_venta' => 10.00,
                'estado' => 1,
                'codigo' => 'PROD-007klKMNBC',
                'descripcion' => 'Tomate',
                'id_proveedor' => 4,

            ],
            [
                'nombre_producto' => 'Zanahoria 1 Libra',
                'stock' => 500,
                'id_categoria' => 4,
                'precio_compra' => 10.00,
                'precio_venta' => 20.00,
                'estado' => 1,
                'codigo' => 'PROD-003lkCM',
                'descripcion' => 'Zanahoria',
                'id_proveedor' => 5,
            ],
            
        ]);

        // 10 registros automáticos
        
    }
}

