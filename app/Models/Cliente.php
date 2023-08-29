<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use function PHPSTORM_META\map;

class Cliente extends Model
{
    use HasFactory;

    protected $table = "cliente";

    protected $primaryKey = "idcliente";

    protected $fillable = [
        "cedula",
        "nombre",
        "apellido",
        "email",
        "fecha_nacimiento",
        "genero",
        "celular",
        "fijo",
        "tipoCliente",
        "rut",
        "estadoDistribuidor",
        "fk_usuario",
        "estado",
        "fk_reclutador"
    ];
    public $timestamps = false;
    
}
