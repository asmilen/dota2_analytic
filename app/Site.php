<?php

namespace App;
use DB;
use Cache;
use App\Match;

class Site
{
    public static function moduleEnable($key_type, $key_content, $key_value)
    {
        $modules = Module::where('key_type', $key_type)
            ->where('key_content', $key_content)
            ->where('key_value', $key_value)
            ->get();

        return ($modules->count() > 0) ? $modules->first() : null;
    }

    /**
     * Using for testing.
     * @param null $uid
     */
    public static function hardLogin($uid = null)
    {
        session()->forget('frontend_login');
        if (!$uid) {
            $uid = random_int(1, 1000000);
        }

        $account = Account::firstOrCreate([
            'uid' => $uid
        ], [
            'username' => 'user_' . $uid,
            'email' => ''
        ]);

        session()->put('frontend_login', $account);

    }

    public static function getMatches()
    {
        $matches = Cache::get('matches');

        if ($matches) {
            return $matches;
        } else {
            return Cache::remember('matches', 5, function () {
                return DB::table('matches')
                    ->join('teams as team1', 'matches.team_a', '=', 'team1.id')
                    ->join('teams as team2', 'matches.team_b', '=', 'team2.id')
                    ->join('leagues','matches.league_id','=','leagues.id')
                    ->select('matches.*', 'team1.full_name as team_a_name', 'team1.image as team_a_image', 'team2.full_name as team_b_name', 'team2.image as team_b_image','leagues.full_name as league_name','leagues.image as league_image')
                    ->whereIn('matches.status',array(
                        config('constants.STATUS_ACTIVE'),
                        config('constants.STATUS_PLAY')))
                    ->orderBy('matches.match_time')
                    ->groupBy('team_a_name','team_b_name')
                    ->get();
            });
        }
    }

    public static function getAllActiveMatches()
    {
        $matches = Cache::get('all_active_matches');

        if ($matches) {
            return $matches;
        } else {
            return Cache::remember('all_active_matches', 2, function () {
                return DB::table('matches')
                    ->select('matches.*')
                    ->whereIn('matches.status',array(
                        config('constants.STATUS_ACTIVE'),
                        config('constants.STATUS_PLAY')))
                    ->orderBy('matches.match_time')
                    ->get();
            });
        }
    }

    public static function getMatchDetail($id)
    {
        $cache_key = 'match_' . $id;

        $match = Cache::get($cache_key);

        if ($match) {
            return $match;
        } else {
            return Cache::remember($cache_key, 10, function () use ($id) {
                return self::getMatchStatitics($id);
            });
        }
    }

    public static function getMatchStatitics($id)
    {
        $match = Match::where('id',$id)->first();
        $matches = DB::table('matches')
            ->join('teams as team1', 'matches.team_a', '=', 'team1.id')
            ->join('teams as team2', 'matches.team_b', '=', 'team2.id')
            ->select('matches.*', 'team1.name as team_a_name', 'team1.image as team_a_image', 'team2.name as team_b_name', 'team2.image as team_b_image')
            ->where(function($queryContainer) use ($match){
                $queryContainer->where(function($query) use ($match){
                    $query->where('team_a', $match->team_a)
                        ->where('team_b', $match->team_b);
                })
                    ->orwhere(function($query) use ($match){
                        $query->where('team_a', $match->team_b)
                            ->where('team_b', $match->team_a);
                    });
            })
            ->where('matches.type','=','normal')
            ->where('matches.status','=',config('constants.STATUS_FINISHED'))
            ->where('matches.result','<>','-1')
            ->orderBy('matches.match_time','desc')
            ->take(5)
            ->get();
        //Lay 5 tran normal gan nhat
        $normal_recent = array();
        foreach ($matches as $value) {
            $normal_recent[] = $value->team_a_name . ' ' . $value->score . ' ' . $value->team_b_name ;
        }
        $match->normal_recent = $normal_recent;

        //Lay ket qua 10 tran gan nhat cua team a
        $matches = DB::table('matches')
            ->join('teams as team1', 'matches.team_a', '=', 'team1.id')
            ->join('teams as team2', 'matches.team_b', '=', 'team2.id')
            ->select('matches.*', 'team1.name as team_a_name', 'team2.name as team_b_name')
            ->where(function($queryContainer) use ($match){
                $queryContainer->where('team_a', $match->team_a)
                    ->orwhere('team_b', $match->team_a);
            })
            ->where('matches.type','=','normal')
            ->where('matches.status','=',config('constants.STATUS_FINISHED'))
            ->where('matches.result','<>','-1')
            ->orderBy('matches.match_time','desc')
            ->take(10)
            ->get();

        $count = 1;
        $count_win = 0;
        $normal_recent = array();
        foreach ($matches as $value) {
            if ($count++ <= 5)
            {
                $normal_recent[] = $value->team_a_name . ' ' . $value->score . ' ' . $value->team_b_name;
            }
            if($value->result == $match->team_a) $count_win++;
        }
        $match->team_a_normal_recent = $normal_recent;
        $match->team_a_normal_recent_win_rate = $count_win * 10 ;


        //Lay ket qua 10 tran gan nhat cua team b
        $matches = DB::table('matches')
            ->join('teams as team1', 'matches.team_a', '=', 'team1.id')
            ->join('teams as team2', 'matches.team_b', '=', 'team2.id')
            ->select('matches.*', 'team1.name as team_a_name', 'team2.name as team_b_name')
            ->where(function($queryContainer) use ($match){
                $queryContainer->where('team_a', $match->team_b)
                    ->orwhere('team_b', $match->team_b);
            })
            ->where('matches.type','=','normal')
            ->where('matches.status','=',config('constants.STATUS_FINISHED'))
            ->where('matches.result','<>','-1')
            ->orderBy('matches.match_time','desc')
            ->take(10)
            ->get();

        $count = 1;
        $count_win = 0;
        $normal_recent = array();
        foreach ($matches as $value) {
            if ($count++ <= 5)
            {
                $normal_recent[] = $value->team_a_name . ' ' . $value->score . ' ' . $value->team_b_name;
            }
            if($value->result == $match->team_b) $count_win++;
        }
        $match->team_b_normal_recent = $normal_recent;
        $match->team_b_normal_recent_win_rate = $count_win * 10 ;

        //Lay 5 tran 10 kills gan nhat
        $matches = DB::table('matches')
            ->join('teams as team1', 'matches.team_a', '=', 'team1.id')
            ->join('teams as team2', 'matches.team_b', '=', 'team2.id')
            ->select('matches.*', 'team1.full_name as team_a_name', 'team1.image as team_a_image', 'team2.full_name as team_b_name', 'team2.image as team_b_image')
            ->where(function($queryContainer) use ($match){
                $queryContainer->where(function($query) use ($match){
                    $query->where('team_a', $match->team_a)
                        ->where('team_b', $match->team_b);
                })
                    ->orwhere(function($query) use ($match){
                        $query->where('team_a', $match->team_b)
                            ->where('team_b', $match->team_a);
                    });
            })
            ->where('matches.type','=','10 kills')
            ->where('matches.status','=',config('constants.STATUS_FINISHED'))
            ->where('matches.result','<>','-1')
            ->orderBy('matches.match_time','desc')
            ->take(5)
            ->get();

        $normal_recent = array();
        foreach ($matches as $value) {
            $normal_recent[] = $value->team_a_name . ' ' . $value->score . ' ' . $value->team_b_name ;
        }
        $match->kill_recent = $normal_recent;

        //Lay ket qua 15 tran gan nhat cua team a
        $matches = DB::table('matches')
            ->join('teams as team1', 'matches.team_a', '=', 'team1.id')
            ->join('teams as team2', 'matches.team_b', '=', 'team2.id')
            ->select('matches.*', 'team1.name as team_a_name', 'team2.name as team_b_name')
            ->where(function($queryContainer) use ($match){
                $queryContainer->where('team_a', $match->team_a)
                    ->orwhere('team_b', $match->team_a);
            })
            ->where('matches.type','=','10 kills')
            ->where('matches.status','=',config('constants.STATUS_FINISHED'))
            ->where('matches.result','<>','-1')
            ->orderBy('matches.match_time','desc')
            ->take(10)
            ->get();

        $count = 1;
        $count_win = 0;
        $normal_recent = array();
        foreach ($matches as $value) {
            if ($count++ <= 5)
            {
                $normal_recent[] = $value->team_a_name . ' ' . $value->score . ' ' . $value->team_b_name . $value->handicap_a ;
            }
            if($value->result == $match->team_a) $count_win++;
        }
        $match->team_a_kill_recent = $normal_recent;
        $match->team_a_kill_recent_win_rate = $count_win * 10 ;


        //Lay ket qua 10 tran gan nhat cua team b
        $matches = DB::table('matches')
            ->join('teams as team1', 'matches.team_a', '=', 'team1.id')
            ->join('teams as team2', 'matches.team_b', '=', 'team2.id')
            ->select('matches.*', 'team1.name as team_a_name', 'team2.name as team_b_name')
            ->where(function($queryContainer) use ($match){
                $queryContainer->where('team_a', $match->team_b)
                    ->orwhere('team_b', $match->team_b);
            })
            ->where('matches.type','=','10 kills')
            ->where('matches.status','=',config('constants.STATUS_FINISHED'))
            ->where('matches.result','<>','-1')
            ->orderBy('matches.match_time','desc')
            ->take(15)
            ->get();

        $count = 1;
        $count_win = 0;
        $normal_recent = array();
        foreach ($matches as $value) {
            if ($count++ <= 5)
            {
                $normal_recent[] = $value->team_a_name . ' ' . $value->score . ' ' . $value->team_b_name . $value->handicap_a ;
            }
            if($value->result == $match->team_b) $count_win++;
        }
        $match->team_b_kill_recent = $normal_recent;
        $match->team_b_kill_recent_win_rate = $count_win * 10 ;

        return $match;
    }

    public static function getMatchFromD2top($url)
    {

        try
        {
            $agent= 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)';

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_VERBOSE, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_USERAGENT, $agent);
            curl_setopt($ch, CURLOPT_URL,$url);
            $json=curl_exec($ch);

            //rate a
            $first_step = explode( '<div class="big bold">' , $json );
            $second_step = explode("|" , $first_step[1] );
            $rate_a = trim($second_step[0]);
            return $rate_a;
        }
        catch (\Exception $ex)
        {
            \Log::error($ex);
            return 0;
        }
    }
}