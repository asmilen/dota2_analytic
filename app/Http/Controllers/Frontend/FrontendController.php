<?php

namespace App\Http\Controllers;

use App\Site;

class FrontendController extends Controller
{

    public $isLoginFix = false; //bypass login process

    /**
     * FrontendController constructor.
     */
    public function __construct()
    {
        if ($this->isLoginFix) {
            Site::hardLogin(261804103);
        }
        $this->middleware('auth.frontend');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function user()
    {
        return view('frontend.index');
    }

    public function index()
    {
        $matches = Site::getMatches();
        return view('frontend.home',compact('matches'));
    }

    public function matchDetail($match_id)
    {
        $match = Site::getMatchDetail($match_id);
        return view('frontend.match_detail',compact('match'));
    }



}