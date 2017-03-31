<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BetSite extends Model
{
    //
    protected $table = 'bet_sites';

    protected $fillable = [
        'name',
    ];

    protected $dates = ['created_at', 'updated_at'];

}
