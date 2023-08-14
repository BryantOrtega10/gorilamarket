<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Domiciliario extends Model
{
    use HasFactory;

    protected $table = "domiciliario";

    protected $primaryKey = "iddomiciliario";

    protected $fillable = [
        "cedula",
        "nombre",
        "apellido",
        "email",
        "celular",
        "estado",
        "fk_usuario"
    ];

    public $timestamps = false;

    public function usuario(){
        return $this->belongsTo(User::class,"fk_usuario","id");
    }
}
