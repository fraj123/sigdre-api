<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Charges extends Model
{
    public function usuarios(){
        return $this->hasOne('App\User');
    }
}
