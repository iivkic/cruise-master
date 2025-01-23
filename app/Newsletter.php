<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Newsletter extends Model
{
    protected $table="mcc_newsletter";
    use SoftDeletes;


    protected $fillable = [
        'email'
    ];
}
