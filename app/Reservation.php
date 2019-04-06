<?php

namespace App;

use Illuminate\Notifications\Notifiable;


class Reservation 
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
   
   

   

    
    
}
