<?php

namespace App;

use App\MccDestination as Destination;
use App\MccImage as Image;
use App\MccItinerary as Itinerary;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class MccExcursion extends Model implements TranslatableContract
{
    use SoftDeletes;
    use Translatable;


    protected $table = "mcc_excursions";
    protected $fillable = ["main_excursion_id", "popular","ch_ship_id","ch_excursion_duration_id","mcc_excursion_category_id","old_id","sequence","online"];
    public $translatedAttributes = ["meta_title","meta_description","name","slug", "islands_cities"];
    protected $appends=["min_price","max_departure"];

    public function scopeGetPrices($query, $date = false, $prices = false,$prices_ids=false)
    {

        return $query->whereHas("prices", function ($q) use ($date, $prices,$prices_ids) {
            $q->select("ed.date", "excursion_prices.id", DB::raw("if(excursion_discounts.id is not null,excursion_discounts.amount,0) as popust"), DB::raw("if(excursion_discounts.id is not null,(excursion_prices.price-(excursion_discounts.amount*excursion_prices.price/100)),excursion_prices.price) as real_price"))->leftjoin("excursion_discount_excursion_price", "excursion_price_id", "excursion_prices.id")
                ->leftjoin("excursion_discounts", function ($join) {
                    $join->on("excursion_discount_id", "=", "excursion_discounts.id");
                    $join->on('start', "<", DB::raw("'" . now() . "'"));
                    $join->on("end", ">", DB::raw("'" . now() . "'"))->whereNull("excursion_discounts.deleted_at");
                });
            if($prices_ids && sizeof($prices_ids)>0){
                $q->whereIn("excursion_prices.id",$prices_ids);
            }
            if ($prices)
                $q->havingRaw("real_price > ? and real_price < ?", [hrk_to_eur($prices[0]), hrk_to_eur($prices[1])]);
            $q->join("excursion_departures as ed", function ($join) {
                $join->on("excursion_departure_id", "=", "ed.id")
                    ->whereNull("ed.deleted_at");
            });
            if ($date)
                $q->havingRaw("month(date)= ? and year(date) = ?", [$date->month, $date->year]);
            else
                $q->havingRaw("date > ?", [now()]);
            $q->groupBy("date","id","real_price","popust");
        })
            ->with(["prices" => function ($q) use ($date, $prices,$prices_ids) {
                $q->select("ed.date", "excursion_prices.*","excursion_prices.price", DB::raw("if(excursion_discounts.id is not null,excursion_discounts.amount,0) as popust"), DB::raw("if(excursion_discounts.id is not null,(excursion_prices.price-(excursion_discounts.amount*excursion_prices.price/100)),excursion_prices.price) as real_price"))->leftjoin("excursion_discount_excursion_price", "excursion_price_id", "excursion_prices.id")
                    ->leftjoin("excursion_discounts", function ($join) {
                        $join->on("excursion_discount_id", "=", "excursion_discounts.id");
                        $join->on('start', "<", DB::raw("'" . now() . "'"));
                        $join->on("end", ">", DB::raw("'" . now() . "'"))->whereNull("excursion_discounts.deleted_at");
                    });
                if($prices_ids && sizeof($prices_ids)>0){
                    $q->whereIn("excursion_prices.id",$prices_ids);
                }
                if ($prices)
                    $q->havingRaw("real_price > ? and real_price < ?", [hrk_to_eur($prices[0]), hrk_to_eur($prices[1])]);
                $q->join("excursion_departures as ed", function ($join) {
                    $join->on("excursion_departure_id", "=", "ed.id")
                        ->whereNull("ed.deleted_at");
                });
                if ($date)
                    $q->havingRaw("month(date)= ? and year(date) = ?", [$date->month, $date->year])->groupBy("date");
                else
                    $q->havingRaw("date > ?", [now()]);
                $q->groupBy("date","excursion_departures.excursion_id","excursion_prices.id","price","excursion_prices.created_at","excursion_prices.updated_at","excursion_prices.deleted_at","excursion_prices.created_by","excursion_prices.updated_by","excursion_prices.deleted_by","open","real_price","popust","excursion_prices.excursion_departure_id","excursion_prices.excursion_room_type_id")->with("room_type");
            }]);
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

    public function header_image()
    {
        return $this->hasOne(Image::class, "id", "header_image_id");
    }
    public function route_image()
    {
        return $this->hasOne(Image::class, "id", "route_image_id");
    }
    public function old()
    {
        return $this->hasOne(OldCruise::class, "id_cruise", "old_id");
    }

    public function images()
    {
        return $this->hasMany(Image::class, "mcc_excursion_id", "id")->orderBy("sequence");
    }
    public function images3()
    {
        return $this->hasMany(Image::class, "mcc_excursion_id", "id")->orderBy("sequence")->limit(3);
    }

    public function itineraries(){
        return $this->hasMany(Itinerary::class,"mcc_excursion_id","id");
    }
    public function itinerary(){
        return $this->hasOne(Itinerary::class,'id','program_id');
    }
    public function duration(){
        return $this->belongsTo(Duration::class,"ch_excursion_duration_id");
    }
    public function ship(){
        return $this->hasOne(Ship::class,"id","ch_ship_id");
    }
    public function category(){
        return $this->belongsTo(Category::class,"ch_excursion_category_id");
    }
    public function start(){
        return $this->hasOne(MccDestination::class,"id","start_id");
    }

    public function finish(){
        return $this->hasOne(MccDestination::class,"id","finish_id");
    }

    public function main_excursion(){
        return $this->belongsTo(MainExcursion::class);
    }

    public function destinations()
    {
        return $this->belongsToMany(Destination::class,'mcc_excursion_destination','mcc_excursion_id','mcc_destination_id',"id")->withPivot(['sequence', 'starting_port', 'ending_port','year'])->orderBy("pivot_sequence");
    }

    function departures(){
        return $this->hasMany(ExcursionDeparture::class,"excursion_id","main_excursion_id")->orderBy('date');
    }
    function prices(){
        return $this->hasManyThrough(ExcursionPrice::class, ExcursionDeparture::class,"excursion_id","excursion_departure_id","main_excursion_id");
    }

    function getMinPriceAttribute()
    {
        return $this->prices->where("real_price", $this->prices->min("real_price"))->first();
    }

    function getMaxDepartureAttribute()
    {
        return $this->departures->max("date");
    }

    function supplements()
    {
        return $this->hasMany(ExcursionSupplements::class, "excursion_id", "main_excursion_id");
    }
}
