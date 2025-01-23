<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExcursionDiscount extends Model
{
    //
    use SoftDeletes;

    protected $casts=["start"=>"date", "end"=>"date", "amount"=>"float"];
    protected $fillable=["partner_id", "name", "start", "end", "amount"];
    public function loadDiscountsForExcursion($excursion){
        $items=[];
        foreach ($excursion->departures as $departure){
            foreach ($departure->prices as $price){
                if($this->prices->contains($price->id)) $items[]=["id"=>$price->id, "name"=>$departure->date->format("d.m.Y")." | ".$price->roomType->name];
            }
        }
        $this->discounted_items=$items;
    }
    public function prices(){
        return $this->belongsToMany(ExcursionPrice::class);
    }
}
