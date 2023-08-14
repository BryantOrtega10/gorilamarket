<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PorcentajesDescuento extends Model
{
    use HasFactory;

    protected $table = "porcentajes_descuento";

    protected $primaryKey = "idporcentajes_descuento";

    protected $fillable = [
        "valor",
        "tipo_valor"
    ];
    public $timestamps = false;

}
