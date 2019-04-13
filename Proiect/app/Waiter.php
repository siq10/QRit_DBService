<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Waiter extends Model
{
    protected $connection = 'mysql_appuser';

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function place()
    {
        return $this->belongsTo('App\Place');
    }
    public function orders()
    {
        return $this->hasMany('App\Order');
    }
}
