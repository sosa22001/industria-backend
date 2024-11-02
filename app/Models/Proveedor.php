<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $table = 'proveedores';
    protected $fillable = ['nombre_proveedor', 'email', 'telefono', 'estado', 'direccion', 'created_by', 'updated_by', 'deleted_by'];
    
}
