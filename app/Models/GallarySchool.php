<?php

namespace App\Models;

use App\School;
use Illuminate\Database\Eloquent\Model;

class GallarySchool extends Model
{
    protected $guarded = [];

    public function school()
    {
        return $this->belongsTo(School::class, 'school_id');
    }

}