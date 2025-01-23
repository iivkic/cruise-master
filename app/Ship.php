<?php

namespace App;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Ship extends Model implements TranslatableContract
{
    use SoftDeletes;
    use Translatable;

    protected $connection="mysql";
    protected $table = "ch_ships";
    protected $fillable = ["main_ship_id","old_id", "capacity", "build", "length", "width", "engine", "speed", "cabins_quantity", "cabin_size", "sequence", "draft", "refit", "max_speed", "charter_price","online"];
    public $translatedAttributes = ["name", "description","meta_title","meta_description","equipment", "highlights", "flag", "slug", "accommodation", "watertoys", "crew", "price_extend", "include", "not_include", "extra_apa", "food", "cabin_configuration", "price_details", "obligatory_supplements", "food_details", "beverage", "beverage_details", "options_extra_headline", "options_extra", "options_extra_details", "not_include_details"];



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
    public function old()
    {
        return $this->hasOne(OldShip::class, "id_brod", "old_id");
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
        return $this->hasOne(ShipImage::class, "id", "header_image_id");
    }
    public function layout_image()
    {
        return $this->hasOne(ShipImage::class, "id", "layout_image_id");
    }

    public function images()
    {
        return $this->hasMany(ShipImage::class, "ch_ship_id", "id")->orderBy("sequence");
    }
    public function images3()
    {
        return $this->hasMany(ShipImage::class, "ch_ship_id", "id")->orderBy("sequence")->limit(3);
    }
    public function images2()
    {
        return $this->images()->limit(2);
    }
    public function category()
    {
        return $this->hasOne(Category::class, "id","ch_ship_category_id");
    }
    public function features(){
        return $this->hasMany(ShipFeatures::class, "ch_ship_id", "id");
    }
    public function main_ship()
    {
        return $this->hasOne(ShipMain::class, "id", "main_ship_id");
    }
}
