<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class InventarioBodega extends Model
{
    protected function serializeDate($date)
    {
        return $date->format('Y-m-d H:i:s');
    }
    
    protected $fillable = ['bodega_id', 'estado_id'];
}
