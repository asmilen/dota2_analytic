<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Validator;

class UsersController extends AdminController
{

    public $model = 'users';

    public $validator = [
        'name' => 'required',
        'email' => 'required|unique:users',
    ];

    private function init()
    {
        return '\\App\\' . ucfirst(str_singular($this->model));
    }

    public function index(Request $request)
    {
        $modelClass = $this->init();
        $searchKeyword = null;
        $contents = $modelClass::latest('created_at');

        if ($request->input('q')) {
            $searchKeyword = urldecode($request->input('q'));
            $contents = $contents->where('title', 'like', '%'.$searchKeyword.'%');
        }

        $contents = $contents->paginate(config('site.item_per_page'));

        return view('admin.'.$this->model.'.index', compact('contents', 'searchKeyword'))->with('model', $this->model);
    }

    public function create()
    {
        $modelClass = $this->init();
        $content = new $modelClass;
        return view('admin.'.$this->model.'.form', compact('content'))->with('model', $this->model);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->validator);

        if ($validator->fails()) {
            return redirect('admin/'.$this->model.'/create')
                ->withErrors($validator)
                ->withInput();
        }
        $data = $request->all();

        if ($request->file('image') && $request->file('image')->isValid()) {
            $data['image'] = $this->saveImage($request->file('image'));
        } else {
            unset($data['image']);
        }

        $modelClass = $this->init();
        $modelClass::create($data);
        flash()->success('Thêm mới thành công!');
        return redirect('admin/'.$this->model);

    }

    public function edit($id)
    {
        $modelClass = $this->init();
        $content = $modelClass::find($id);
        return view('admin.'.$this->model.'.form', compact('content'))->with('model', $this->model);
    }

    public function update($id, Request $request)
    {

        //unique validation.
        $this->validator['email'] .= ',email,' . $id;

        $validator = Validator::make($request->all(), $this->validator);

        if ($validator->fails()) {
            return redirect('admin/'.$this->model.'/' . $id . '/edit')
                ->withErrors($validator)
                ->withInput();
        }
        $modelClass = $this->init();
        $content = $modelClass::find($id);
        $data = $request->all();
        if ($request->file('image') && $request->file('image')->isValid()) {
            $data['image'] = $this->saveImage($request->file('image'), $content->image);
        } else {
            unset($data['image']);
        }
        $content->update($data);

        flash()->success('Chỉnh sửa thành công!');
        return redirect('admin/'.$this->model);
    }
    //not enabled destroyed user.

   /* public function destroy($id)
    {
        $modelClass = $this->init();
        $content = $modelClass::find($id);
        $content->delete();
        flash()->success('Xóa thành công!');
        return redirect('admin/'.$this->model);
    }*/
}