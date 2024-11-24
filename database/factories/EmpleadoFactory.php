<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Puesto;
use App\Models\User;

class EmpleadoFactory extends Factory
{
    protected $model = \App\Models\Empleado::class;

    public function definition(): array
    {
        return [
            'dni_empleado' => $this->faker->unique()->numberBetween(100000000, 999999999), // DNI único
            'primer_nombre' => $this->faker->firstName(), // Primer nombre
            'segundo_nombre' => $this->faker->optional()->firstName(), // Segundo nombre opcional
            'primer_apellido' => $this->faker->lastName(), // Primer apellido
            'segundo_apellido' => $this->faker->lastName(), // Segundo apellido
            'id_puesto' => Puesto::factory(), // Genera un puesto asociado
            'estado' => $this->faker->boolean(), // Estado aleatorio
            'direccion' => $this->faker->address(), // Dirección aleatoria
            'email' => $this->faker->unique()->safeEmail(), // Email único
            'telefono' => $this->faker->phoneNumber(), // Teléfono aleatorio
            'fecha_nacimiento' => $this->faker->date(), // Fecha de nacimiento aleatoria
            'fecha_ingreso' => $this->faker->date(), // Fecha de ingreso aleatoria
            'rtn' => $this->faker->unique()->numberBetween(100000000000, 999999999999), // RTN único
            'id_user' => User::factory(), // Genera un usuario asociado
        ];
    }
}

