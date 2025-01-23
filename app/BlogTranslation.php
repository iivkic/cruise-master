<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogTranslation extends Model
{
    use SoftDeletes;
    public $timestamps=false;
    protected $table = "blog_translations";
    public $fillable = ["name","text","meta_title","meta_description","slug"];
}
