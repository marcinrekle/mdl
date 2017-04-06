<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Field;
use App\Role;
use Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = Role::find(4)->users()->with('attrs')->get();//add active check
        return view('user.index', compact('users'));
        dd($users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //dd($id);
        $user = User::whereId($id)->first();
        $fields = Field::whereActive(1)->get();
        return view('auth.edit', compact('user','fields'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,id',
        ]);
        if($validator->fails()) return redirect()->back()->withErrors($validator)->withInput();
        $user = User::findOrFail($id)->load('attrs');
        //dump($user);
        $user->fill($data);
        $user->attrs->fill($data)->save();
        //$user->attrs['values'] = $data['values'];
        //$user->attrs->save();
        //dd($user);
        $user->push();
        //$user->save();
        //dump($user);
        //dd('stop');
        return redirect()->back();
        //dd($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
