<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Direccion extends Model
{
    use HasFactory;

    protected $table = "direccion";

    protected $primaryKey = "iddireccion";

    protected $fillable = [
        "fk_cliente",
        "dir1",
        "dir2",
        "dir3",
        "dir5",
        "adicional",
        "lat",
        "lng",
        "direccionCompleta",
        "cobertura",
        "barrio"
    ];
    public $timestamps = false;
}
