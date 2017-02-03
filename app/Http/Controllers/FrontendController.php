<?php

namespace App\Http\Controllers;

use App\Site;

class FrontendController extends Controller
{

    public $isLoginFix = false; //bypass login process

    public function __construct()
    {
        if ($this->isLoginFix) {
            Site::hardLogin(261804103);
        }
        $this->middleware('auth.frontend');
    }

    public function user()
    {
        return view('frontend.index');
    }


}