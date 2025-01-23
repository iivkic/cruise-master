<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class ExcursionDeparture extends Model
{

    use SoftDeletes;
    protected $fillable=['open', 'allotment', 'excursion_id', 'date'];
    protected $casts=["date"=>"date"];
    protected $appends=["min_price"];

    public function scopeGetPrices($query, $date=false,$prices=false){
        if($date)
            $query->whereMonth("date",$date->month)->whereYear("date",$date->year);
        else
            $query->where("date",">",now());

        $query->whereHas("prices", function($q) use($date,$prices){
            $q->select( "excursion_prices.*", DB::raw("if(excursion_discounts.id is not null,excursion_discounts.amount,0) as popust"), DB::raw("if(excursion_discounts.id is not null,(excursion_prices.price-(excursion_discounts.amount*excursion_prices.price/100)),excursion_prices.price) as real_price"))->leftjoin("excursion_discount_excursion_price", "excursion_price_id", "excursion_prices.id")
                ->leftjoin("excursion_discounts", function ($join) {
                    $join->on("excursion_discount_id", "=", "excursion_discounts.id");
                    $join->on('start', "<", DB::raw("'" . now() . "'"));
                    $join->on("end", ">", DB::raw("'" . now() . "'"));
                    $join->on("end", ">", DB::raw("'" . now() . "'"))->whereNull("excursion_discounts.deleted_at");
                });
            if($prices)
                $q->havingRaw("real_price > ? and real_price < ?",[hrk_to_eur($prices[0]),hrk_to_eur($prices[1])]);


            $q->groupBy("excursion_prices.id","real_price","popust");
        });
        $query->with(["prices" => function($q) use($date,$prices){
            $q->select( "excursion_prices.*", DB::raw("if(excursion_discounts.id is not null,excursion_discounts.amount,0) as popust"), DB::raw("if(excursion_discounts.id is not null,(excursion_prices.price-(excursion_discounts.amount*excursion_prices.price/100)),excursion_prices.price) as real_price"))->leftjoin("excursion_discount_excursion_price", "excursion_price_id", "excursion_prices.id")
                ->leftjoin("excursion_discounts", function ($join) {
                    $join->on("excursion_discount_id", "=", "excursion_discounts.id");
                    $join->on('start', "<", DB::raw("'" . now() . "'"));
                    $join->on("end", ">", DB::raw("'" . now() . "'"));
                    $join->on("end", ">", DB::raw("'" . now() . "'"))->whereNull("excursion_discounts.deleted_at");
                });
            if($prices)
                $q->havingRaw("real_price > ? and real_price < ?",[hrk_to_eur($prices[0]),hrk_to_eur($prices[1])]);


            $q->groupBy("excursion_prices.id","price","excursion_prices.created_at","excursion_prices.updated_at","excursion_prices.deleted_at","excursion_prices.created_by","excursion_prices.updated_by","excursion_prices.deleted_by","open","real_price","popust","excursion_prices.excursion_departure_id","excursion_prices.excursion_room_type_id");
        },"prices.room_type"]);
    }
    public function prices()
    {
        return $this->hasMany(ExcursionPrice::class);
    }
    public function excursion(){
        return $this->belongsTo(MccExcursion::class,"excursion_id","main_excursion_id");
    }

    public function discounts(){
        return $this->belongsToMany(ExcursionDiscount::class,"");
    }
    public function getMinPriceAttribute(){
        return $this->prices->where("real_price",$this->prices->min("real_price"))->first();
    }
}
