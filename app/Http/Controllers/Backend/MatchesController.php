<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Match;

class MatchesController extends AdminController
{
    //

    public function index(Request $request)
    {   
        $matches = Match::latest()->paginate(config('site.item_per_page'));
        return view('admin.match.index', compact('matches'));
    }

    public function create()
    {       
        return view('admin.match.create');
    }

    public function edit($id)
    {
        $match = Match::find($id);
        return view('admin.match.form', compact('match'));
    }
    
    public function store(Request $request)
    {
        $data = $request->all();
        $data['status'] = -1;
        $bo = intval(substr($data['rounds'],2,1));

        if (isset($data['normal'])) 
        {
            $data['type'] = 'normal';
            Match::create($data);
        }
        
        if (isset($data['10kills'])) 
        {
            $data['type'] = '10 kills';
            for ($i=1; $i <= $bo; $i++) { 
                $data['handicap_a'] = '[10Kills map' . $i . ']';
                $data['handicap_b'] = '[10Kills map' . $i . ']';
                Match::create($data);
            }
        }

        if (isset($data['fb'])) 
        {
            $data['type'] = 'fb';
            for ($i=1; $i <= $bo; $i++) { 
                $data['handicap_a'] = '[FirstBlood map' . $i . ']';
                $data['handicap_b'] = '[FirstBlood map' . $i . ']';
                Match::create($data);
            }
        }
        if (isset($data['handicap_a1'])) 
        {
            $data['type'] = 'handicap';
            switch ($bo) {
                case 2:
                    $data['handicap_a'] = '[-0.5]';
                    $data['handicap_b'] = '[+0.5]';
                    Match::create($data);
                    break;
                case 3:
                    $data['handicap_a'] = '[-1.5]';
                    $data['handicap_b'] = '[+1.5]';
                    Match::create($data);
                    break;
                case 5:
                    $data['handicap_a'] = '[-1.5]';
                    $data['handicap_b'] = '[+1.5]';
                    Match::create($data);
                    $data['handicap_a'] = '[-2.5]';
                    $data['handicap_b'] = '[+2.5]';
                    Match::create($data);
                    break;
                default:
                    # code...
                    break;
            }
        }

        if (isset($data['handicap_b1'])) 
        {
            $data['type'] = 'handicap';
            switch ($bo) {
                case 2:
                    $data['handicap_b'] = '[-0.5]';
                    $data['handicap_a'] = '[+0.5]';
                    Match::create($data);
                    break;
                case 3:
                    $data['handicap_b'] = '[-1.5]';
                    $data['handicap_a'] = '[+1.5]';
                    Match::create($data);
                    break;
                case 5:
                    $data['handicap_b'] = '[-1.5]';
                    $data['handicap_a'] = '[+1.5]';
                    Match::create($data);
                    $data['handicap_b'] = '[-2.5]';
                    $data['handicap_a'] = '[+2.5]';
                    Match::create($data);
                    break;
                default:
                    # code...
                    break;
            }
        }

        flash('Create Matches success!', 'success');
        return redirect('admin/matches');
    }

    

}
