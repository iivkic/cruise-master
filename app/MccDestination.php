<?php

namespace App;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MccDestination extends Model implements TranslatableContract
{
    use SoftDeletes;
    use Translatable;

    protected $connection="mysql";
    protected $table = "mcc_destinations";
    protected $hidden=[];
    protected $fillable = ["name", "longitude", "latitude", "online","sequence","old_id"];
    public $translatedAttributes = [ "description","weather","meta_title","meta_description", "slug","short_description"];



    public function attributesToArray()
    {
        $attributes = parent::attributesToArray();

        if (
            (! $this->relationLoaded('translations') && ! $this->toArrayAlwaysLoadsTranslations() && is_null(self::$autoloadTranslations))
            || self::$autoloadTranslations === false
        ) {
            return $attributes;
        }

        $hiddenAttributes = $this->getHidden();

        foreach ($this->translatedAttributes as $field) {
            if (in_array($field, $hiddenAttributes)) {
                continue;
            }

            $attributes[$field] = $this->getAttributeOrFallback(null, $field);
        }
        foreach ( config("translatable.locales") as $l) {
            $attributes[$l]=$this->translateOrNew(mb_strtolower($l));
        }


        return $attributes;
    }
    public function special_fill(array $attributes)
    {
        foreach ($attributes as $key => $values) {
            if (
                $this->getLocalesHelper()->has($key)
                && is_array($values)
            ) {
                $this->getTranslationOrNew($key)->fill($values);
                unset($attributes[$key]);
            }
        }

        return parent::fill($attributes);
    }
    public function header_image()
    {
        return $this->hasOne(MccImage::class, "id", "header_image_id");
    }

    public function images()
    {
        return $this->hasMany(MccImage::class, "mcc_destination_id", "id")->orderBy("sequence");
    }
    public function old()
    {
        return $this->hasOne(OldDestination::class, "id_destinacija", "old_id");
    }
    public function start_cruise()
    {
        return $this->belongsTo(MccExcursion::class, "id", "start_id")->where("online",1);
    }
    public function finish_cruise()
    {
        return $this->belongsTo(MccExcursion::class, "id", "finish_id")->where("online",1);
    }

}
