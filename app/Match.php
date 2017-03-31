<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Match extends Model
{
    //
    protected $table = 'matches';

    protected $fillable = [
        'team_a',
        'team_b',

        'match_time',

        'rate_a',
        'rate_b',

        'result',
        'league_id',
        'status',

        'handicap_a',
        'handicap_b',

        'rounds',
        'type',
        'desc',
        'score',
    ];

    protected $dates = ['created_at', 'updated_at','match_time'];

    public function teamA()
    {
       return $this->belongsTo(Team::class, 'team_a');
    }

    public function teamB()
    {
        return $this->belongsTo(Team::class, 'team_b');
    }

    public function League()
    {
        return $this->belongsTo(League::class, 'league_id');
    }
}
