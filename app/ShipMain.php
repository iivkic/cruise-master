<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class ShipMain extends Model
{
    use SoftDeletes;
//    use Translatable;

    protected $connection="mysql";
    protected $table = "ships";
    protected $fillable=["id", "name"];

}
