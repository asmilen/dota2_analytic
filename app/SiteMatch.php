<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SiteMatch extends Model
{
    //
    protected $table = 'sites_matches';

    protected $fillable = [
        'match_id',

        'rate_a',
        'rate_b',
        'url',
    ];

    protected $dates = ['created_at', 'updated_at'];

    public function Match()
    {
        return $this->belongsTo(Match::class, 'match_id');
    }
}
