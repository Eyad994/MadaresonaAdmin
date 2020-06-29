<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Finance extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    /*protected $casts = [
        'start_date' => 'datetime:Y/m/d',
        'end_date' => 'datetime:Y/m/d',
    ];*/

}
