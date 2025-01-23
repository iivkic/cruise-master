<?php

namespace App;

use Buglinjo\LaravelWebp\Facades\Webp;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\App;

class ShipImage extends Model
{
    use SoftDeletes;
    protected $table="ch_images";
    protected $appends=["webps"];

    public function getWebpsAttribute(){
        $result=["url"=>substr($this->url,0,-3)."webp","thumbnail_120"=>substr($this->thumbnail_120,0,-3)."webp","thumbnail_320"=>substr($this->thumbnail_320,0,-3)."webp","thumbnail_375"=>substr($this->thumbnail_375,0,-3)."webp","thumbnail_620"=>substr($this->thumbnail_620,0,-3)."webp","thumbnail_768"=>substr($this->thumbnail_768,0,-3)."webp","thumbnail_1150"=>substr($this->thumbnail_1150,0,-3)."webp"];
        if(App::environment('local')){
            foreach($result as $key=>$value){
               if($key!="url") $result[$key]="https://mycroatiacruise.com".$value;
            }
        }
        return (object)$result;
    }

    public function getUrlAttribute($url)
    {
        if(App::environment('local')){
            return "https://mycroatiacruise.com".$url;
        }
        return $url;
    }


}
