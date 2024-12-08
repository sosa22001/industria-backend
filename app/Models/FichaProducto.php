<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FichaProducto extends Model
{
    use HasFactory;

    protected $table = 'ficha_producto';

    protected $fillable = [
        'ficha_inventario_id', 'producto_id', 'cantidad', 'precio_compra', 'lote', 'devuelto'
    ];

    public function fichaInventario()
    {
        return $this->belongsTo(FichaInventario::class);
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
