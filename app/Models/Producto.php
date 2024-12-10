<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'productos';
    protected $fillable = [
        'nombre_producto',
        'stock',
        'id_categoria',
        'precio_compra',
        'precio_venta',
        'estado',
        'codigo',
        'descripcion',
        'id_proveedor',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    // Relación con la categoría
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'id_categoria');
    }

    // Relación con DetalleVenta
    public function detallesVentas()
    {
        return $this->hasMany(DetalleVenta::class, 'producto_id');
    }

    // Relación con el proveedor
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'id_proveedor');
    }

    // Accesor y mutador para el campo `estado`
    protected function estado(): Attribute
    {
        return Attribute::make(
            get: fn($value) => (bool) $value,
            set: fn($value) => $value ? 1 : 0
        );
    }
}
