<?php


namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShipFeatures extends Model
{
    use SoftDeletes;
    protected $connection="mysql";
    protected $table = "ch_ship_features";
    protected $fillable = ["ch_ship_id","naziv"];

}
