<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Venta extends Model
{
    use HasFactory;

    protected $table = 'ventas';

    protected $fillable = [
        'fecha_venta',
        'id_producto',
        'id_empleado',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    // Relación con el producto
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto');
    }

    // Relación con el empleado
    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'id_empleado');
    }

    // Accesor y mutador para el campo `fecha_venta`
    protected function fechaVenta(): Attribute
    {
        return Attribute::make(
            get: fn($value) => \Carbon\Carbon::parse($value), // Convierte el valor a Carbon al obtenerlo
            set: fn($value) => $value // Puedes aplicar más lógica aquí si es necesario
        );
    }
}






