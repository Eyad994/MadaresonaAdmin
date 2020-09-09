<?php

namespace App\Models;

use App\Models\City;
use App\Models\Region;
use App\Models\Status;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class School extends Model

{
    use SoftDeletes;

    protected $guarded = [];

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function region()
    {
        return $this->belongsTo(Region::class, 'region_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
