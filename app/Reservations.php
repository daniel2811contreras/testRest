<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reservations extends Model
{
    /**
     * 
     * @var array
     */
    protected $fillable = [
        'Restaurant_id',
        'Cliente',
        'Fecha_reserva'
    ];
}
