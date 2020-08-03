<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Class_name;

class User extends Model
{
   // use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'class_id','phone_no'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    // protected $hidden = [
    //     'password', 'remember_token',
    // ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    // protected $casts = [
    //     'email_verified_at' => 'datetime',
    // ];



       public function classData()
    {

        return $this->belongsTo(Class_name::class,'class_id','id');
    }



}
