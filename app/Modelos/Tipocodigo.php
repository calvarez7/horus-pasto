<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Tipocodigo extends Model
{
    protected function serializeDate($date)
    {
        return $date->format('Y-m-d H:i:s');
    }
    
    protected $fillable = [
        'Nombre', 'Descripcion', 'Estado_id',
    ];
}
