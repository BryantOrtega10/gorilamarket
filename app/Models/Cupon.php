<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cupon extends Model
{
    use HasFactory;

    protected $table = "cupon";

    protected $primaryKey = "idcupon";

    protected $fillable = [
        "cupon",
        "valor",
        "tipoValor",
        "no_cupones",
        "apFecha",
        "fecha_inicio",
        "fecha_fin",
        "apPrecio",
        "precio_inicial",
        "precio_final",
        "estado"
    ];
    public $timestamps = false;
}
