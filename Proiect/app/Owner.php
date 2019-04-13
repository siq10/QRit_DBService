<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    protected $connection = 'mysql_appuser';

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
