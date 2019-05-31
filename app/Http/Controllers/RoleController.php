<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use App\Http\Controllers\Controller;
use Validator;

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
        return response()->json(['roles'=> $roles,],200);
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
        //if($validator->fails()) return redirect()->back()->withErrors($validator)->withInput();
        if($validator->fails()) return response()->json(['role' => $role,'msg' => 'Wystąpiły błędy','error' => $validator],422);
        $role = Role::create($data);
        return response()->json(['role' => $role,'msg' => 'Dodano nową rolę'],200);
        //return redirect()->route('role.index')->withSuccess('Rola utworzona');
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
        //if($validator->fails()) return redirect()->back()->withErrors($validator)->withInput();
        if($validator->fails()) return response()->json(['role' => $role,'msg' => 'Wystąpiły błędy','error' => $validator],422);
        $role->update($data);
        return response()->json(['role' => $role,'msg' => 'Zaktualizowano rolę'],200);
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
        return response()->json(['role' => $role,'msg' => 'Usunieto rolę'],200);
        //return redirect()->route('role.index')->withSuccess('Rola usunięta');
    }

    public function permissionGrouped()
    {
        dd("test pG");
    }

    /**
     * Show the form for editing permission the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function permissionOld()
    {
        //$rolePerm = $role->perms->pluck('name');
        $permissions = Permission::all()->sortBy('groupName');
        $perm = collect(); 
        $permissions->each(function ($item, $key) use ($perm) {
            $cat = explode("-", $item->name);
            if( !isset($perm[$cat[0]])){
                $perm[$cat[0]] = collect();
            }
            $perm[$cat[0]]->push($item);
        });
        $permissions = $perm;
        return response()->json(['permissions'=> $permissions,'msg' => 'Pobrano uprawnienia RC'],200);
        //dd($role,$permissions, $rolePerm);
        //dd($perm, $permissions);
        return view('role.permission', compact('role','permissions', 'rolePerm'));
    }

     /**
     * Show the form for editing permission the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function permission()
    {
        //$rolePerm = $role->perms->pluck('name');
        
        // $perm = collect(); 
        // $permissions->each(function ($item, $key) use ($perm) {
        //     $cat = explode("-", $item->name);
        //     if( !isset($perm[$cat[0]])){
        //         $perm[$cat[0]] = collect();
        //     }
        //     $perm[$cat[0]]->push($item);
        // });
        // $permissions = $perm;
        $permissions = Permission::all();
        $permissionsIds = $permissions->pluck('id');
        $permissionsGrouped = $permissions->groupBy('groupName');
        $permissionsGroupedIds = $permissionsGrouped->mapWithKeys(function($item,$key){
            return [$key => $item->pluck('id')->all()];
        })->all();
        //dd($permissionsGroupedIds);
        //dd($permissions,$permissionsGrouped, $permissionsIds,$permissionsGroupedIds);
        return response()->json(['permissions'=> $permissionsGrouped,'roleWithPerms' => $this->roleWithPerms(),'msg' => 'Pobrano uprawnienia RC'],200);
        return view('role.permission', compact('role','permissions', 'rolePerm'));
    }

    public function permissionUpdate(Request $request, Role $role)
    {
        $data = $request->all();
        //$data['perms'] = isset($data['perms']) ? $data['perms']:[];
        //$perms = implode(',', $data['perms']);
        //dd($role,$data);
        $role->perms()->sync($data);
        return response()->json(['msg' => 'Pomyslnie zaktualizowano','roleWithPerms' => $this->roleWithPerms()],200);
        //return redirect()->route('role.permission')->withSuccess('Zmieniono');
        return redirect()->back()->withSuccess('Zmieniono');
    }

    protected function roleWithPerms()
    {
        return Role::with('perms')->get()->mapWithKeys(function($item){
            return [$item->name => $item->perms()->pluck('id')->all()];
        })->all();
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
