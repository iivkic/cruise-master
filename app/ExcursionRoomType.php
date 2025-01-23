<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class ExcursionRoomType extends Model
{
    //
    protected $fillable=['name', 'beds', 'extra_bed', 'allotment', 'excursion_id', 'sequence'];

    public function image(){
        return $this->hasOne(MccImage::class, 'excursion_room_type_id');
    }
}
