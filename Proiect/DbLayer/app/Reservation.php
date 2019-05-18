<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Reservation extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $connection = 'mysql_appuser';



    public function client()
    {
        return $this->belongsTo('App\Client');
    }

    public function place()
    {
        return $this->belongsTo('App\Place');
    }
    
    
}
