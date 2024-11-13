<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // Asegúrate de importar HasFactory
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model // Cambiar el nombre de la clase a singular
{
    use HasFactory;

    protected $table = 'categorias';
    protected $fillable = ['nombre_categoria','descripcion_categoria']; // Agregar los campos que se pueden llenar
}

