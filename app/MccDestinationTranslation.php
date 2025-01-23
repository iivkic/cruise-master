<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MccDestinationTranslation extends Model
{
    use SoftDeletes;
    public $timestamps=false;
    protected $table = "mcc_destination_translations";
    public $fillable = ["description","weather","meta_title","meta_description","slug","short_description"];
}
