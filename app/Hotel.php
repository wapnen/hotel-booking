<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    //
    protected $fillable = ['name', 'address', 'city', 'state', 'country', 'zip', 'phone', 'email'];


    public function rooms(){
      return $this->hasMany('App\Room');
    }
}
