<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Foto extends Model
{
    use HasFactory;

    protected $table = "fotos";

    protected $primaryKey = "idfotos";

    protected $fillable = [
        "ruta",
        "orden",
        "fk_producto"
    ];

    public $timestamps = false;

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'fk_producto', 'idproducto');
    }
}
