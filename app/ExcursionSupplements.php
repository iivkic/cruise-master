<?php

namespace App;

use App\Http\MainExcursion;
use Illuminate\Database\Eloquent\Model;

class ExcursionSupplements extends Model
{
    protected $table="excursion_supplements";

    public function supplements(){
        return $this->hasMany(MainExcursion::class);
    }
}
