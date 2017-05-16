<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Role;
use App\Permission;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all();
        return view('role.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('role.create');
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
        if($validator->fails()) return redirect()->back()->withErrors($validator)->withInput();
        $role = Role::create($data);
        return redirect()->route('role.index')->withSuccess('Rola utworzona');
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
    public function edit(Role $role)
    {
        return view('role.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $data = $request->all();
        $validator = $this->validator($data);
        if($validator->fails()) return redirect()->back()->withErrors($validator)->withInput();
        $role->update($data);
        return redirect()->route('role.index')->withSuccess('Rola zaktualizowana');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('role.index')->withSuccess('Rola usunięta');
    }

    /**
     * Show the form for editing permission the specified resource.
     *
     * @param  Role  $role
     * @return \Illuminate\Http\Response
     */
    public function permission(Role $role)
    {
        $rolePerm = $role->perms->pluck('name');
        $permissions = Permission::all()->sortBy('name');
        $perm = collect(); 
        $permissions->each(function ($item, $key) use ($perm) {
            $cat = explode("-", $item->name);
            if( !isset($perm[$cat[0]])){
                $perm[$cat[0]] = collect();
            }
            $perm[$cat[0]]->push($item);
        });
        $permissions = $perm;
        //dd($role,$permissions, $rolePerm);
        //dd($perm, $permissions);
        return view('role.permission', compact('role','permissions', 'rolePerm'));
    }

    public function permissionUpdate(Request $request, Role $role)
    {
        $data = $request->all();
        $data['perms'] = isset($data['perms']) ? $data['perms']:[];
        $perms = implode(',', $data['perms']);
        //dd($role,$data,$perms);
        $role->perms()->sync($data['perms']);
        //return redirect()->route('role.permission')->withSuccess('Zmieniono');
        return redirect()->back()->withSuccess('Zmieniono');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name'    => 'required|min:3|max:32',
            'display_name'  => 'required|min:3|max:32',
            'description'  => '',
        ]);
    }
}
