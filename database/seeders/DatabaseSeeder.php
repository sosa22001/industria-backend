<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Seeders\CategoriaSeeder;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        User::factory()->create([
            'name' => 'Elmer',
            'email' => 'elmer@example.com',
            'password' => bcrypt('12345678'), // Contraseña segura
        ]);

        User::factory()->create([
            'name' => 'Elder',
            'email' => 'elder@example.com',
            'password' => bcrypt('12345678'), // Contraseña segura
        ]);

        User::factory()->create([
            'name' => 'Esdras',
            'email' => 'esdras@example.com',
            'password' => bcrypt('12345678'), // Contraseña segura
        ]);

        $this->call([
            CategoriaSeeder::class,
            ProveedorSeeder::class,
            ProductoSeeder::class,
            PuestoSeeder::class,
            EmpleadoSeeder::class,
            RoleAndPermissionSeeder::class,
            
        ]);
    }
}
