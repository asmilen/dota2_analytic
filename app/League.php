<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class League extends Model
{
    //

    protected $table = 'leagues';

    protected $fillable = [
        'name',
        'desc',
        'image',
        'status',
        'full_name'
    ];

    protected $dates = ['created_at', 'updated_at'];
}
