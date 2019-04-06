<?php

namespace App;

use Illuminate\Notifications\Notifiable;


class Menu 
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
