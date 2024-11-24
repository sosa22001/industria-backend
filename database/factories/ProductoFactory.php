<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Categoria;
use App\Models\Proveedor;

class ProductoFactory extends Factory
{
    protected $model = \App\Models\Producto::class;

    public function definition(): array
    {
        return [
            'nombre_producto' => $this->faker->word(), // Nombre aleatorio
            'stock' => $this->faker->numberBetween(0, 100), // Cantidad en stock aleatoria
            'id_categoria' => Categoria::factory(), // Genera una categoría asociada
            'precio_compra' => $this->faker->randomFloat(2, 10, 500), // Precio de compra aleatorio
            'precio_venta' => $this->faker->randomFloat(2, 15, 1000), // Precio de venta aleatorio
            'estado' => $this->faker->boolean(), // Estado aleatorio (activo/inactivo)
            'codigo' => $this->faker->unique()->bothify('PROD-###???'), // Código único
            'descripcion' => $this->faker->sentence(), // Descripción del producto
            'id_proveedor' => Proveedor::factory(), // Genera un proveedor asociado
        ];
    }
}

