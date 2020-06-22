<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Paymenet extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'added_by');
    }
}
