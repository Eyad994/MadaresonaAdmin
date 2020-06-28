<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class SaleFinance extends Model
{
    protected $table = 'sale_finances';
    protected $guarded = [];
    protected $dates = ['date'];

    public function user()
    {
        return $this->belongsTo(User::class, 'added_by');
    }
}
