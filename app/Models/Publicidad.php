<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publicidad extends Model
{
    use HasFactory;

    protected $table = "publicidad";

    protected $primaryKey = "idpublicidad";

    protected $fillable = [
        "imagen",
        "link",
        "tipo"
    ];

    public $timestamps = false;

    protected function tipo(): Attribute{
        return new Attribute(
            get: fn($value) => ["", "WEB - 1","WEB - 2","WEB - 3","APP"][$value]
        );
    }

    public function producto(){
        return $this->belongsTo(Producto::class, "link","idproducto");
    }
}
