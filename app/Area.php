<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $fillable = ['image','title_ar', 'title_en','city_id','deleted'];

    public function City() {
        if(session('lang')){
            $lang = session('lang');
        }else{
            $lang = app()->getLocale() ;
        }
        return $this->belongsTo('App\City', 'city_id')->select('id','title_'.$lang.' as title');
    }
}
