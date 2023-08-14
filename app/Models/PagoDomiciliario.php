<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PagoDomiciliario extends Model
{
    use HasFactory;
    protected $table = "pago_domiciliario";

    protected $primaryKey = "idpago_domiciliario";

    protected $fillable = [
        "fk_pago",
        "fk_domiciliario",
        "fecha",
        "estado"
    ];

    public $timestamps = false;
}
