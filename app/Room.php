<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    //
    protected $fillable = ['name' ];

    public function hotel(){
      return $this->belongsTo('App\Hotel');
    }

    public function roomType(){
      return $this->belongsTo('App\RoomType');
    }
}
