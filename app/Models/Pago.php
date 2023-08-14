<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;

    protected $table = "pago";

    protected $primaryKey = "idpago";

    protected $fillable = [
        "fecha",
        "estado",
        "concepto",
        "valor",
        "direccion",
        "cd_referido",
        "fk_usuario",
        "tipo_pago",
        "fecha_recib",
        "hora_recib",
        "fk_cliente",
        "csto_Dom",
        "descuento",
        "fk_direccion",
        "ultima_observacion",
        "plataforma",
        "fk_usuarioAlisto"
    ];

    public $timestamps = false;

    public function cliente(){
        return $this->belongsTo(Cliente::class, "fk_cliente", "idcliente");
    }

    public function hora_cast(){
        $arr = ["horaMan" => "Mañana", "horaTar" => "Tarde", "horaNoc" => "Noche"];
        return $arr[$this->hora_recib];        
    }

    public function estados(){
        return $this->hasMany(PagoEstado::class, "fk_pago","idpago");
    }

    public function direccion_r(){
        return $this->belongsTo(Direccion::class, "fk_direccion", "iddireccion");
    }

    
}
