<?php

namespace App\Services\Fias;

class F15Service {
    
    public function generar($consulta){
        $array = array();
        foreach($consulta as $item){
            array_push($array, implode('|', $item->toArray()));
        }
        return $array;
    }

} 