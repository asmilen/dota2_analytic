<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Team;

class TeamsController extends AdminController
{
    public $model = 'teams';

    public $validator = [
        'name' => 'required',
    ];

    public function index(Request $request)
    {
        $teams = Team::latest()->paginate(config('site.item_per_page'));
        return view('admin.team.index', compact('teams'));
    }

    public function create()
    {       
        return view('admin.team.form');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->validator);

        if ($validator->fails()) {
            return redirect('admin/teams/create')
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->all();

        $data['status'] = ($request->input('status') == 'on') ? true : false;
        $data['image'] =  ($request->file('image') && $request->file('image')->isValid()) ? $this->saveImage($request->file('image')) : '';
        
        Team::create($data);

        flash('Create team success!', 'success');
        return redirect('admin/teams');
    }


    /**
     * display form for edit category
     * @param $id
     * @return $this
     */
    public function edit($id)
    {
        $team = Team::find($id);
        return view('admin.team.form', compact('team'));
    }

    /**
     * @param $id
     * @param CategoryRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
        $validator = Validator::make($request->all(), $this->validator);

        if ($validator->fails()) {
            return redirect('admin/teams/create')
                ->withErrors($validator)
                ->withInput();
        }
        
        $team = Team::find($id);
        $data = $request->all();

        $data['status'] = ($request->input('status') == 'on') ? true : false;

        if ($request->file('image') && $request->file('image')->isValid()) {
            $data['image'] = $this->saveImage($request->file('image'), $team->image);
        } else {
            unset($data['image']);
        }

        $team->update($data);

        flash('Update team success!', 'success');
        return redirect('admin/teams');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $team = Team::find($id);

        if (file_exists(public_path('files/' . $team->image))) {
            @unlink(public_path('files/' . $team->image));
        }
        $team->delete();
        flash('Success deleted team!');
        return redirect('admin/teams');
    }



}
