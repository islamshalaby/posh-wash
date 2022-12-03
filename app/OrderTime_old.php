<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderTime_old extends Model
{
    protected $guarded = [];
    protected $dates = ['order_date'];

    public function Detail()
    {
        return $this->belongsTo('App\OrderDetail', 'order_details_id');
    }
}
