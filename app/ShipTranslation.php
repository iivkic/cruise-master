<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShipTranslation extends Model
{
    use SoftDeletes;
    public $timestamps=false;
    protected $table = "ch_ship_translations";
    public $fillable = ["name", "description","meta_title","meta_description","equipment", "highlights", "flag", "slug"];
}
