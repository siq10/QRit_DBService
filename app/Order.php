<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Order extends Model
{
    protected $connection = 'mysql_appuser';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function client()
    {
        return $this->belongsTo('App\Client');
    }
    public function table()
    {
        return $this->belongsTo('App\Table');
    }
    public function waiter()
    {
        return $this->belongsTo('App\Waiter');
    }
    public function products()
    {
        return $this->belongsToMany('App\Product')->withTimestamps();
    }
}
