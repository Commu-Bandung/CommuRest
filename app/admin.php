<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class admin extends Model
{
    protected $fillable = [
        'nama','email','password','api_token',
    ];

    protected $hidden = [
        'password','remember_token'
    ];
}
