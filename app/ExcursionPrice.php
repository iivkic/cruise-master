<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExcursionPrice extends Model
{
    //
    protected $fillable = ["excursion_departure_id", "excursion_room_type_id", "open", "price"];
    protected $casts = ["price" => "float"];
    protected $appends = ["max_discount"];
    use SoftDeletes;

    public function room_type()
    {
        return $this->belongsTo(ExcursionRoomType::class, 'excursion_room_type_id');
    }

    public function discounts()
    {
        return $this->belongsToMany(ExcursionDiscount::class);
    }


    public function getMaxDiscountAttribute()
    {
        return $this->discounts->max("amount");
    }
}