<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class MccDayTranslation extends Model
{
    public $timestamps=false;
    protected $table = "mcc_itinerary_day_translations";
    public $fillable = ["text"];

}
