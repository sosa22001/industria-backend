<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PuestoFactory extends Factory
{
    protected $model = \App\Models\Puesto::class;

    public function definition(): array
    {
        return [
            'nombre_del_puesto' => $this->faker->jobTitle(), // Genera un nombre de puesto aleatorio
        ];
    }
}

