<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model
{
    //
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'added_by');
    }
}
