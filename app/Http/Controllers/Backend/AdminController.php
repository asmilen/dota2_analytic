<?php

namespace App\Http\Controllers\Backend;

use App\User;
use App\Site;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Image;
use Laravel\Socialite\Facades\Socialite;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth.backend',  ['except' => [
            'redirectToGoogle',
            'handleGoogleCallback',
            'logout',
            'notice'
        ]]);
    }

    public function notice()
    {
        return view('admin.notification');
    }

    /** Redirect to G+ authenticate.
     * @return mixed
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }


    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();

            $user = User::where('email', $user->email)->get();

            if ($user->count() > 0) {
                session()->put('admin_login', $user->first());
                return redirect('admin');
            } else {
                flash('User with email='.$user->email.' not existed in database.', 'error');
                return redirect('admin/notice');
            }
        } catch (Exception $e) {
            dd($e);
            flash('You do not have permission to access! : ', 'error');
            return redirect('admin/notice');
        }

    }

    public function logout()
    {
        session()->forget('admin_login');
        flash('Goodbye!');
        return redirect('admin/notice');
    }

    public function index(Request $request)
    {
       $user = session()->get('admin_login');
       return view('admin.index', compact('user'));
    }

    public function saveImage($file, $old = null)
    {
        $filename = md5(uniqid().'_'.time()) . '.' . $file->getClientOriginalExtension();
        Image::make($file->getRealPath())->save(public_path('files/' . $filename));
        if ($old) {
            @unlink(public_path('files/' . $old));
        }
        return $filename;
    }

    protected function syncContent($relation, $ids, $extra_data, $extra_field)
    {
        $syncArrays = [];

        foreach ($ids as $k => $id) {
            if ($id && isset($extra_data[$k]) && $extra_data[$k]) {
                $syncArrays[$id] = [$extra_field => $extra_data[$k]];
            }
        }
        if ($syncArrays) {
            $relation->sync($syncArrays);
        }
    }


    /**
     * Using for admin ajax if needed
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        //$data = request()->all();
        $status = false;

        return response()->json(['status' => $status]);
    }


}
