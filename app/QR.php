<?php

namespace App;

use Illuminate\Notifications\Notifiable;


class QR 
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
  
   function table()
   {
   	return $this->hasOne('App\QR');
   }

   

    
    
}
