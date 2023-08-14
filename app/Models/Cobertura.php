<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cobertura extends Model
{
    use HasFactory;

    protected $table = "perimetro";

    protected $primaryKey = "idperimetro";

    protected $fillable = [
        "perimetro",
        "perimetro_txt",
        "perimetro_txt2",
        "nombre"
    ];

    public $timestamps = false;

    public function getPerimetroJson(){
        $perf2 = [];
        $perimetros2 = explode(",", $this->perimetro_txt2);
        foreach ($perimetros2 as $perimetro2) {
            $perimetros3 = explode(" ", $perimetro2);
            $perf2[] = [
                "lat" => doubleval($perimetros3[0]),
                "lng" => doubleval($perimetros3[1])
            ];
        }
        
        return json_encode($perf2);
    }

    public function getPrimerPunto(){
        $perf2 = [];
        $perimetros2 = explode(",", $this->perimetro_txt2);
        $perimetro2 = $perimetros2[0];
        $perimetros3 = explode(" ", $perimetro2);
        return [
            "lat" => doubleval($perimetros3[0]),
            "lng" => doubleval($perimetros3[1])
        ];
    }
}
