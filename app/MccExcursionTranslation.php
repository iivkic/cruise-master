<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class MccExcursionTranslation extends Model
{

    public $timestamps=false;
    protected $table = "mcc_excursion_translations";
    public $fillable = ["meta_title","meta_description","slug","name"];
}
