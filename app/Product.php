<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;



class Product extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

      public function orders()
    {
        return $this->belongsToMany('orders', 'order_product', 'order_id', 'product_id');
    }
    
}
