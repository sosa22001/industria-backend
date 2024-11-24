<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Models\DetalleVenta;

class Venta extends Model
{
    use HasFactory;

    protected $table = 'ventas';

    protected $fillable = [
        'fecha_venta',
        'subtotal',
        'isv',
        'descuento',
        'total',
        'id_empleado',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    // Relación con los detalles de la venta
    public function detalles()
    {
        return $this->hasMany(DetalleVenta::class, 'venta_id');
    }

    // Relación con el usuario que registró la venta
    public function usuario()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Relación con el empleado que realizó la venta (opcional)
    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'id_empleado');
    }
}






