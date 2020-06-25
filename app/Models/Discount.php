<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    //
    public function level()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }
    public function region()
    {
        return $this->belongsTo(Region::class, 'region_id');
    }
}
