<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    protected $connection = 'mysql_appuser';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function tables()
    {
        return $this->hasMany('App\Table');
    }
   
   public function reservations()
   {
        return $this->hasMany('App\Reservation');
   }

    public function waiters()
    {
        return $this->hasMany('App\Waiter');
    }
    public function ratings()
    {
        return $this->hasMany('App\Rating');
    }
    public function orders()
    {
        return $this->hasMany('App\Order');
    }
    public function owner()
    {
        return $this->belongsTo('App\Owner');
    }
    public function products()
    {
        return $this->hasMany('App\Product');
    }

}
