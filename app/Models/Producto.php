<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Auth;

class Producto extends Model
{
    use HasFactory;

    protected $table = "producto";

    protected $primaryKey = "idproducto";

    protected $fillable = [
        "nombre",
        "descripcion",
        "precio",
        "precioDist",
        "unidades",
        "destacado",
        "fecha_creacion",
        "fk_categorias",
        "fk_marca",
        "cd_barras",
        "orden",
        "slug"
    ];

    public $timestamps = false;

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'fk_categorias', 'idcategorias');
    }

    protected function visible(): Attribute{
        return new Attribute(
            get: fn($value) => [-1 => "Elimnado", 0 => "Oculto", 1 => "Visible"][$value]
        );
    }

    public function fotoPpal()
    {
        $foto = Foto::where("fk_producto","=",$this->idproducto)->orderBy("orden","asc")->first();
        return $foto;
    }

    public function precioClDi(){        
        if(Auth::check()){
            if(Auth::user()->role == "distribuidor"){
                return $this->precioDist;        
            }
        }        
        return $this->precio;        
    }

    public function promocion(){      
        $hoy = date("Y-m-d");  
        $promo = Promocion::where("fk_producto","=",$this->idproducto)
                          ->where("fecha_inicio","<=",$hoy)
                          ->where("fecha_fin",">=",$hoy)
                          ->first();

        return $promo;        
    }

    public function precioPromo(){      
        $precio = $this->precioClDi();  
        $promo = $this->promocion();
        if(isset($promo)){
            $precio = $precio - (($precio * $promo->porcentaje) / 100);
        }
        return $precio;        
    }
    
    
    public function getRouteKeyName()
    {        
        return 'slug';
    }

    
}
