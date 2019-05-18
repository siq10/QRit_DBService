<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $connection = 'mysql_appuser';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function categories()
    {
        return $this->belongsToMany('App\Category');
    }
    public function place()
    {
        return $this->belongsTo('App\Place');
    }

    public function orders()
    {
        return $this->belongsToMany('App\Order')->withTimestamps();
    }
    
}
