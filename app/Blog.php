<?php

namespace App;

use App\MccImage as Image;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model implements TranslatableContract
{
    use SoftDeletes;
    use Translatable;


    protected $table = "blogs";

    protected $fillable = ["sequence", "created_at","online"];
    public $translatedAttributes = ["name", "meta_title", "meta_description", "text",
        "slug",
        "popular"];


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


                unset($attributes[$key]);
            }
        }


        return parent::fill($attributes);
    }
    public function getTranslationOrNew(?string $locale = null): Model
    {

        $locale = $locale ?: $this->locale();

        if (($translation = $this->getTranslation($locale, false)) === null) {
            $translation = $this->getNewTranslation($locale);
        }

        return $translation;
    }
    public function header_image()
    {
        return $this->hasOne(Image::class, "id", "header_image_id");
    }

}
