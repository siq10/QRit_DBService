<?php

namespace App;



use Illuminate\Database\Eloquent\Model;

class Table extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function place()
    {
        return $this->belongsTo('App\Place');
    }
    public function orders()
    {
        return $this->hasMany('App\Order');
    }
    
}
