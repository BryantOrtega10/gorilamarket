<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reclutador extends Model
{
    use HasFactory;

    protected $table = "reclutador";

    protected $primaryKey = "id_reclutador";

    protected $fillable = [
        "cedula",
        "nombre",
        "apellido",
        "email",
        "celular",
        "estado",
        "valor_recaudado",
        "valor_pagado",
        "fk_usuario"
    ];
    
    public $timestamps = false;

    public function usuario(){
        return $this->belongsTo(User::class,"fk_usuario","id");
    }
}
