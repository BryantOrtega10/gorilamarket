<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PagoEstado extends Model
{
    use HasFactory;

    protected $table = "pago_estado";

    protected $primaryKey = "idpago_estado";

    protected $fillable = [
        "estado",
        "descripcion",
        "fecha_sistema",
        "fk_pago"
    ];
    public $timestamps = false;
}
