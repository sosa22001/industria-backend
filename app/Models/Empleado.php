<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Empleado extends Model
{
    use HasFactory;

    protected $table = 'empleados';
    
    protected $fillable = [
        'dni_empleado',
        'primer_nombre',
        'segundo_nombre',
        'primer_apellido',
        'segundo_apellido', 
        'id_puesto',
        'estado', // Manteniendo el nombre
        'direccion',  
        'email',
        'telefono',
        'fecha_nacimiento',
        'fecha_ingreso',
        'rtn',
        'id_user'
    ];

    // Relación con el puesto
    public function puesto()
    {
        return $this->belongsTo(Puesto::class, 'id_puesto');
    }

    // Relación con el usuario
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    // Accesor y mutador para el campo `estado`
    protected function estado(): Attribute
    {
        return Attribute::make(
            get: fn($value) => (bool) $value, // Devuelve verdadero o falso
            set: fn($value) => $value ? 1 : 0 // Almacena como 1 o 0
        );
    }
}
