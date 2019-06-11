<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;
use App\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$this->middleware('permission:permission-retrive|permission-crud');
        $permissions = Permission::all()->sortBy('groupName')->values()->all();
        return response()->json(['permissions'=> $permissions,'msg' => 'Pobrano uprawnienia'],200);
        return view('permission.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('permission.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $validator = $this->validator($data);
        //if($validator->fails()) return redirect()->back()->withErrors($validator)->withInput();
        if($validator->fails()) return response()->json($validator->messages(),422);
        $permission = Permission::create($data);
        return response()->json(['permissions' => $permission,'msg' => 'Dodano nowe uprawnienie'],201);
        return redirect()->route('permission.index')->withSuccess('Uprawnienie utworzono');
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
    public function edit(Permission $permission)
    {
        return view('permission.edit', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permission $permission)
    {
        $data = $request->all();
        $validator = $this->validator($data);
        //if($validator->fails()) return redirect()->back()->withErrors($validator)->withInput();
        if($validator->fails()) return response()->json($validator->messages(),422);
        $permission->update($data);
        return response()->json(['permissions' => $permission,'msg' => 'Zaktualizowano uprawnienie'],201);
        return redirect()->route('permission.index')->withSuccess('Uprawnienie zaktualizowano');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {
        $permission->delete();
        return redirect()->route('permission.index')->withSuccess('Uprawnienie usunięte');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name'    => ['required','min:3','max:32',Rule::unique('permissions')->ignore($data['name'])],
            'display_name'  => 'required|min:3|max:32',
            'description'  => '',
            'groupName'  => 'required|min:3|max:32',
        ]);
    }
}
