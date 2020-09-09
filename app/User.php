<?php

namespace App;

use App\Models\School;
use App\Models\Supplier;
use App\Models\SupplierMessage;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'type', 'active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    protected $guarded = [];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'id', 'user_id');
    }

    public function school()
    {
        return $this->belongsTo(School::class, 'id', 'user_id');
    }

    public function supplierMessage()
    {
        return $this->hasMany(SupplierMessage::class, 'user_id')->where('seen', 0);
    }

}
