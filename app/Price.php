<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    //
    protected $fillable = ['price', 'room_type_id'];

    public function roomType(){
      return $this->belongsTo('App\RoomType');
    }
}
