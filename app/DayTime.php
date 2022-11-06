<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DayTime extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    protected $table = 'day_times';

    public function getTimeFromAttribute($time)
    {
        return date('g:i a', strtotime($time));;
    }
    public function getTimeToAttribute($time)
    {
        return date('g:i a', strtotime($time));;
    }


    public function OrderTimes() {
        return $this->hasMany('App\OrderTime', 'time_id')->where('order_times.start', 1);
    }

    public function OrderTimes2($date) {
        return $this->hasMany('App\OrderTime', 'time_id')->where('order_times.start', 1)->whereDate('order_date', $date)->where('status', 'done')->count();
    }
}
