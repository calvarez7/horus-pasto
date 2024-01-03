<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Rep extends Model
{
    protected function serializeDate($date)
    {
        return $date->format('Y-m-d H:i:s');
    }
    
    protected $guarded = [];

    public function movimientos()
    {
        return $this->hasMany('App\Modelos\Movimiento');
    }
}
