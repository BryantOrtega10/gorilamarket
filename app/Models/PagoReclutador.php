<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PagoReclutador extends Model
{
    use HasFactory;

    protected $table = "pago_reclutador";

    protected $fillable = [
        "fk_reclutador",
        "num_pago",
        "valor_pagado"
    ];

}
