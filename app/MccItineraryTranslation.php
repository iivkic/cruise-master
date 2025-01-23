<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class MccItineraryTranslation extends Model
{
    public $timestamps=false;
    protected $table = "mcc_excursion_itinerary_translations";
    public $fillable = ["include_ship","include_meal","include_wifi","include_help","include_luggage","include_service","include_excursions","not_include","include_note"];

}
