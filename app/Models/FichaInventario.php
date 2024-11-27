<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FichaInventario extends Model
{
    use HasFactory;

    protected $table = 'fichas_inventario';

    protected $fillable = [
        'proveedor_id', 'tipo_movimiento', 'estado', 'fecha_pedido', 'fecha_recepcion', 'comentarios'
    ];

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }

    public function fichaProductos()
    {
        return $this->hasMany(FichaProducto::class);
    }
}
