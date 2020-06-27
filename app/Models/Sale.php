<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $guarded = [];
    protected $dates = ['date'];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
