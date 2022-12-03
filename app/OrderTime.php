<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderTime extends Model
{
    protected $guarded = [];

    public function Detail()
    {
        return $this->belongsTo('App\OrderDetail', 'order_details_id');
    }
    public function Time_details()
    {
        return $this->belongsTo('App\DayTime', 'time_id');
    }
}
