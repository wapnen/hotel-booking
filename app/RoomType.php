<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoomType extends Model
{
    //
    protected $fillable = ['name'];

    public function rooms(){
      return $this->hasMany('App\Room');
    }

    public function price(){
      return $this->hasOne('App\Price');
    }
}
