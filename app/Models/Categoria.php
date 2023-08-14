<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Categoria extends Model
{
    use HasFactory;

    protected $table = "categorias";

    protected $primaryKey = "idcategorias";

    protected $fillable = [
        "nombre",
        "slug",
        "imagen",
        "tipo",
        "link",
        "id_categoria_sup",
        "orden_cat"
    ];

    public $timestamps = false;

    public function sub_categorias()
    {
        return $this->hasMany(Categoria::class, 'id_categoria_sup', 'idcategorias');
    }

    public function categoria_superior(){
        return $this->belongsTo(Categoria::class, 'id_categoria_sup','idcategorias');
    }

    public function getRouteKeyName()
    {        
        return 'slug';
    }
}
