<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $connection = 'mysql_appuser';

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function reservations()
    {
        return $this->hasMany('App\Reservation');
    }
    public function ratings()
    {
        return $this->hasMany('App\Rating');
    }
    public function orders()
    {
        return $this->hasMany('App\Order');
    }

}
