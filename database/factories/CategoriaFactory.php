<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CategoriaFactory extends Factory
{
    protected $model = \App\Models\Categoria::class;

    public function definition(): array
    {
        return [
            'nombre_categoria' => $this->faker->word(), // Nombre aleatorio
            'descripcion_categoria' => $this->faker->sentence(), // Descripción aleatoria
            'created_by' => null, // O puedes agregar un ID de usuario si aplica
            'updated_by' => null,
        ];
    }
}
