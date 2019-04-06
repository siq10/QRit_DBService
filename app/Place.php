<?php

namespace App;

use Illuminate\Notifications\Notifiable;


class Place 
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function table()
    {
        return $this->hasMany('App\Table');
    }
   
   public function reservation()
   {
    
        return $this->hasMany('App\Reservation');

   }

   

    
    
}
