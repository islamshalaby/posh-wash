<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $guarded = [];
    protected $hidden = ['deleted'];
    public function User()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
    public function Address()
    {
        return $this->belongsTo('App\UserAddress', 'address_id');
    }
    public function Times() {
        return $this->hasMany('App\OrderTime', 'order_details_id')->with('Time_details');
    }

    public function Last_time()
    {
        return $this->belongsTo('App\OrderTime', 'order_details_id')->with('Time');
    }
    public function Plan()
    {
        if(session('lang')){
            $lang = session('lang');
        }else{
            $lang = app()->getLocale() ;
        }
        return $this->belongsTo('App\Plan', 'plan_id')->select('id','title_'.$lang.' as title','price','work_hours', 'cat_id');
    }
    public function Web_Plan()
    {
        return $this->belongsTo('App\Plan', 'plan_id');
    }

    public function Category()
    {
        if(session('lang')){
            $lang = session('lang');
        }else{
            $lang = app()->getLocale() ;
        }
        return $this->belongsTo('App\Category', 'category_id')->select('id','title_'.$lang.' as title', 'image');
    }

    public function SubCategory()
    {
        if(session('lang')){
            $lang = session('lang');
        }else{
            $lang = app()->getLocale() ;
        }
        return $this->belongsTo('App\SubCategory', 'sub_category_id')->select('id','title_'.$lang.' as title');
    }
}
