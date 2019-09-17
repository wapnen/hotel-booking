<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    //
    protected $fillable = ['room_id', 'start', 'end', 'customer_name', 'customer_email'];

    public function room(){
      return $this->belongsTo('App\Room');
    }
}
