<?php

namespace App;

use App\MccDay as Day;
use App\MccImage as Image;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MccItinerary extends Model implements TranslatableContract
{
    use SoftDeletes;
    use Translatable;
    protected $table = "mcc_excursion_itineraries";
    protected $fillable=["name","route_image_id","sequence","year"];
    public $translationForeignKey="mcc_excursion_itinerary_id";
    public $translatedAttributes = ["include_ship","include_meal","include_wifi","include_help","include_luggage","include_service","include_excursions", "not_include","include_note"];
    public function days(){
        return $this->hasMany(Day::class,"mcc_excursion_itinerary_id","id");
    }
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

    public function route_image()
    {
        return $this->hasOne(Image::class, "id", "route_image_id");
    }

}
