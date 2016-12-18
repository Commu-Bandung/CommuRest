<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class perusahaan extends Model
{
    protected $fillable = [
        'nama','alamat','email','password','deskripsi','api_token',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}
