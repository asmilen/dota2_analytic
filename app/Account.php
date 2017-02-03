<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $fillable = [
        'uid',
        'username',
        'password',
        'remember_token',
        'email'
    ];
}
