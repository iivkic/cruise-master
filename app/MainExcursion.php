<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MainExcursion extends Model
{
    protected $table="excursions";

    public function excursion(){
        return $this->belongsTo(Excursion::class,"id","main_excursion_id");
    }
    public function mcc_excursion(){
        return $this->belongsTo(MccExcursion::class,"id","main_excursion_id");
    }
}
