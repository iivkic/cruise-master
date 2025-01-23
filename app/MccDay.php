<?php

namespace App;

use App\MccDestination as Destination;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class MccDay extends Model implements TranslatableContract
{
    use SoftDeletes;
    use Translatable;

    protected $table = "mcc_itinerary_days";
    protected $fillable = ["name", "sequence"];
    public $translatedAttributes = ["text"];
    public $translationForeignKey="mcc_itinerary_day_id";
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

    public function destinations()
    {
        return $this->belongsToMany(Destination::class,'mcc_itinerary_day_destinations','mcc_itinerary_day_id','mcc_destination_id');
    }
    public function meals()
    {
        return $this->belongsToMany(Meal::class,'mcc_excursion_meal','mcc_itinerary_day_id','ch_meal_id',"id");
    }
    public function translations(): HasMany
    {
        return $this->hasMany($this->getTranslationModelName(), $this->getTranslationRelationKey());
    }

    /**
     * @return string
     */

}
