<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Proveedor;

class ProveedorSeeder extends Seeder
{
    public function run(): void
    {
        // 5 registros manuales
        DB::table('proveedores')->insert([
            [
                'nombre_proveedor' => 'Distribuidora Los Ángeles',
                'email' => 'contacto@losangeles.com',
                'telefono' => '987654321',
                'estado' => 1,
                'direccion' => 'Barrio El Centro, Tegucigalpa',
            ],
            [
                'nombre_proveedor' => 'Cerveceria Hondureña',
                'email' => 'contacto@elsol.com',
                'telefono' => '876543210',
                'estado' => 1,
                'direccion' => 'Colonia Kennedy, Tegucigalpa',
            ],
            [
                'nombre_proveedor' => 'Comercializadora Luna',
                'email' => 'ventas@luna.com',
                'telefono' => '765432109',
                'estado' => 1,
                'direccion' => 'Colonia El Pedregal, Tegucigalpa',
            ],
            [
                'nombre_proveedor' => 'Distribuidora San José',
                'email' => 'info@sanjose.com',
                'telefono' => '654321098',
                'estado' => 0,
                'direccion' => 'Barrio San Rafael, Choluteca',
            ],
            [
                'nombre_proveedor' => 'Comercial El Faro',
                'email' => 'ventas@elfaro.com',
                'telefono' => '543210987',
                'estado' => 1,
                'direccion' => 'Colonia Las Palmas, Comayagüela',
            ],
        ]);

        // 10 registros automáticos
       
    }
}

