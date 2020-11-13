<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Restaurants extends Model
{
    use SoftDeletes;
    /**
     * 
     * @var array
     */
    protected $fillable = [
        'Nombre',
        'Descripcion',
        'Direccion',
        'Ciudad',
        'Url_foto'
    ];
}
