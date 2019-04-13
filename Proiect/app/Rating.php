<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    public function client()
    {
        return $this->belongsTo('App\Client');
    }

    public function place()
    {
        return $this->belongsTo('App\Place');
    }
}
