<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupplierGallery extends Model
{
    protected $guarded = [];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

}
