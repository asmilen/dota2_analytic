<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    //
    protected $table = 'teams';
    
    protected $fillable = [
        'name',
        'desc',
        'image',
        'status'
    ];

    protected $dates = ['created_at', 'updated_at'];
}
