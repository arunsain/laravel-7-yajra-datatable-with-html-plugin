<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Class_name extends Model
{
    //
    public function user()
    {
        return $this->hasOne(User::class,'class_id','id');
    }
}
