<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Empleado;

class EmpleadoSeeder extends Seeder
{
    public function run(): void
    {
        // 5 registros manuales
        DB::table('empleados')->insert([
            [
                'dni_empleado' => '0801199500012', // Valor único
                'primer_nombre' => 'Esdras',
                'segundo_nombre' => 'Rigoberto',
                'primer_apellido' => 'Castillo',
                'segundo_apellido' => 'Vindel',
                'id_puesto' => 1, // ID de puesto existente
                'estado' => 1,
                'direccion' => 'Colonia Las Palmas, Tegucigalpa',
                'email' => 'esdrasvindell99@example.com',
                'telefono' => '987654321',
                'fecha_nacimiento' => '1995-01-01',
                'fecha_ingreso' => '2020-01-01',
                'rtn' => '0801199500012',
                'id_user' => 4, // ID de usuario existente
            ],
            [
                'dni_empleado' => '0801199600023', // Valor único
                'primer_nombre' => 'Elder',
                'segundo_nombre' => 'Felipe',
                'primer_apellido' => 'Lopez',
                'segundo_apellido' => 'Martinez',
                'id_puesto' => 2,
                'estado' => 1,
                'direccion' => 'Colonia Kennedy, Tegucigalpa',
                'email' => 'elder@example.com',
                'telefono' => '876543210',
                'fecha_nacimiento' => '1996-02-15',
                'fecha_ingreso' => '2021-06-15',
                'rtn' => '0801199600023',
                'id_user' => 3,
            ],
            [
                'dni_empleado' => '0801199600045', // Cambiado a un valor único
                'primer_nombre' => 'Elmerr',
                'segundo_nombre' => 'Cristian',
                'primer_apellido' => 'Lopez',
                'segundo_apellido' => 'Martinez',
                'id_puesto' => 4,
                'estado' => 1,
                'direccion' => 'Colonia Kenney, Tegucigalpa',
                'email' => 'elmervn@example.com',
                'telefono' => '876543210',
                'fecha_nacimiento' => '1996-02-15',
                'fecha_ingreso' => '2021-06-15',
                'rtn' => '0801199604023',
                'id_user' => 2,
            ],
       
        

            // Otros registros manuales...
        ]);

       
    }
}

