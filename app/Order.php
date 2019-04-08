<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;



class Order extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */


     public function products()
    {
        return $this->belongsToMany('products', 'order_product', 'order_id', 'product_id');
    }
   
        
      
    
    
    
}
