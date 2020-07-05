<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use SoftDeletes;

    protected $guarded = [];

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

    public function supplierMessage()
    {
        return $this->belongsTo(SupplierMessage::class, 'user_id', 'user_id');
    }
}
