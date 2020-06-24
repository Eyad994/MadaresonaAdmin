<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'by_admin');
    }

    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }
}
