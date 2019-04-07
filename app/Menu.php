<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;




class Menu extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function place()
    {
        return $this->belongsTo('App\Place');
    }
   

    public function men()
    {
        return $this-> belongsTo('App\Menu');
    }
   

    
    
}
