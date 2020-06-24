<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    protected $guarded = [];

    public function type()
    {
        return $this->belongsTo(FaqType::class, 'type_id');
    }
}
