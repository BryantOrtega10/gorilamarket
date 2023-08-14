<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permisos extends Model
{
    use HasFactory;

    protected $table = "permisos";

    protected $primaryKey = "idpermisos";

    protected $fillable = [
        "fk_menu",
        "fk_user"
    ];

    public $timestamps = false;
}
