<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];

    public function User()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
