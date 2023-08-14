<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promocion extends Model
{
    use HasFactory;

    protected $table = "promociones";

    protected $primaryKey = "idpromociones";

    protected $fillable = [
        "fk_producto",
        "porcentaje",
        "fecha_inicio",
        "fecha_fin"
    ];

    public $timestamps = false;

    public function producto(){
        return $this->belongsTo(Producto::class,"fk_producto", "idproducto");
    }
}
