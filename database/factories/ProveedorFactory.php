<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProveedorFactory extends Factory
{
    protected $model = \App\Models\Proveedor::class;

    public function definition(): array
    {
        return [
            'nombre_proveedor' => $this->faker->company(), // Nombre de proveedor aleatorio
            'email' => $this->faker->unique()->safeEmail(), // Email único
            'telefono' => $this->faker->phoneNumber(), // Número de teléfono aleatorio
            'estado' => $this->faker->boolean(), // Estado aleatorio (true/false)
            'direccion' => $this->faker->address(), // Dirección aleatoria
        ];
    }
}
