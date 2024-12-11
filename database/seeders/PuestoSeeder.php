<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Puesto;

class PuestoSeeder extends Seeder
{
    public function run(): void
    {
        // 5 registros manuales
        DB::table('puestos')->insert([
            ['nombre_del_puesto' => 'Gerente General'],
            ['nombre_del_puesto' => 'Asistente Administrativo'],
            ['nombre_del_puesto' => 'Desarrollador de Software'],
            ['nombre_del_puesto' => 'Analista de Sistemas'],
            ['nombre_del_puesto' => 'Técnico de Soporte'],
        ]);

        // 10 registros automáticos
       
    }
}

