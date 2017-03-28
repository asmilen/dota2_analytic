<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Validator;
use App\League;

class LeaguesController extends AdminController
{
    public $model = 'leagues';

    public $validator = [
        'name' => 'required',
    ];

    public function index(Request $request)
    {
        $leagues = League::latest()->paginate(config('constants.ADMIN_ITEM_PER_PAGE'));
        return view('admin.league.index', compact('leagues'));
    }

    public function create()
    {       
        return view('admin.league.form');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->validator);

        if ($validator->fails()) {
            return redirect('admin/leagues/create')
                ->withErrors($validator)
                ->withInput();
        }
        $data = $request->all();

        $data['status'] = ($request->input('status') == 'on') ? true : false;
        $data['image'] =  ($request->file('image') && $request->file('image')->isValid()) ? $this->saveImage($request->file('image')) : '';
        
        League::create($data);

        flash('Create League success!', 'success');
        return redirect('admin/leagues');
    }


    /**
     * display form for edit category
     * @param $id
     * @return $this
     */
    public function edit($id)
    {
        $league = League::find($id);
        return view('admin.league.form', compact('league'));
    }

    /**
     * @param $id
     * @param CategoryRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
        //unique validation.
        $this->validator['email'] .= ',email,' . $id;

        $validator = Validator::make($request->all(), $this->validator);

        if ($validator->fails()) {
            return redirect('admin/leagues/edit')
                ->withErrors($validator)
                ->withInput();
        }

        $league = League::find($id);
        $data = $request->all();

        $data['status'] = ($request->input('status') == 'on') ? true : false;

        if ($request->file('image') && $request->file('image')->isValid()) {
            $data['image'] = $this->saveImage($request->file('image'), $league->image);
        } else {
            unset($data['image']);
        }

        $league->update($data);

        flash('Update League success!', 'success');
        return redirect('admin/leagues');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $league = League::find($id);

        if (file_exists(public_path('files/' . $league->image))) {
            @unlink(public_path('files/' . $league->image));
        }
        $league->delete();
        flash('Success deleted League!');
        return redirect('admin/leagues');
    }



}
