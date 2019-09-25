<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Field;
use App\Role;
use App\Drive;
use App\Service;

use Validator;
use Auth;
use Carbon\Carbon;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fields = Field::all()->keyBy('order'); 
        $permissions = Auth::user()->roles[0]->permissions->pluck('name')->all();
        $roles = Role::all();
        $roles = $roles->filter(function ($item) use ($permissions) {
            $srole = strtolower($item->name);
            return in_array($srole."-retrive", $permissions) || in_array($srole."-crud", $permissions);
        });
        $rolesNames = $roles->pluck('name');
        // get users with specific roles specified by perms
        /*$users = Role::whereIn('name',$roles)->with('users')->get()->pluck('users')->flatMap(function($values){
            return $values;
        });*/
        $relations = ['users','users.attrs', 'users.services.hours.drive', 'users.payments', 'users.roles'];
        $users = Role::whereIn('name',$rolesNames)->with($relations)->get()->pluck('users')->flatten()->keyBy('id')->values();
        $users = $users->sortBy('name')->values();
        //dd($users);
        //$users = Role::whereIn('name',$roles)->with($relations)->get()->pluck('users')->flatten()->all();
        //dd([$users,$roles, $permissions]);
        return response()->json(['users' => $users, 'roles' => $roles, 'permissions' => $permissions, 'fields' => $fields]);
        $usersAll = User::with($relations)->get();//get all active users
        //return view('user.index', compact('users'));
        return response()->json([$users,$usersAll, $relations, $permissions]);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $allow_rules = ['required','unique','min','max'];
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.$data['id'],
            'password' => 'sometimes|required|min:6',
        ]);
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
        $data = $request->all();
        $this->validator($data)->validate();
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'avatar' => public_path().'/img/defaultUser.png',
            'confirm_code' => str_random(32),
            'status' => $data['status'],
        ]);
        $values = $data['attrs']['values'];
        $values = array_map(function($v){
            return $v ?: '';
        },$values);
        $user->attrs()->create(['values' => $values]);
        $role = Role::whereName($data['roles'])->first();
        $user->attachRole($role);
        return response()->json(['user' => $user->load('roles'),'msg' => 'Dodano nowego użytkownika']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id = null)
    {
        //dd(User::find($id)->with('attrs')->first());
        if(!$id) $id = (int)Auth::user()->id;
        if( is_numeric($id) ){
            $role = User::whereId($id)->first()->roles()->get();
            switch ($role[0]->name) {
                case 'Student':
                    return $this->show_student($id); 
                    break;
                case 'Instructor':
                    return $this->show_instructor($id); 
                    break;
                case 'Officce':
                    return $this->show_role('student'); 
                    break;
                case 'Admin':
                    return $this->show_role('admin'); 
                    break;
                default:
                    # code...
                    break;
            }
        }else{
             return $this->show_role($id);   
        }
        
    }

    public function show_role($role)
    {
        $users = Role::whereName($role)->with('users.attrs')->get()[0]['users']->where('status','active');
        return response()->json(['users' => $users, 'role' => $role,]);
        //return view('user.role_show', compact('users','role'));
    }
    
    public function student_hours($students)
    {
        foreach ($students as $key => $value) {
            
        }
    }

    public function show_student($id)
    {
        $user = User::whereId($id)->with('attrs','payments','hours.drive')->first();
        //$paymentsList = $user->payments;
        $payed = $user->payments->groupBy('payment_for')->map(function ($item, $key){
            return $item->sum('amount');
        });
        $costNames = Field::where("name","like",'%cost%')->orderBy('name')->pluck('slug','name');
        $drivesPerWeek = collect([200,500,1000]);
        if(isset($payed['course'])){   
            $user->dpw = $drivesPerWeek->filter( function ($item, $key) use ($payed) {
                return $item <= $payed['course'];
            })->count();
        }else{
            $user->dpw = 0;
        }
        if($user->hours->sum('count')+$user->attrs->values['old_hours'] < $user->attrs->values['hours'] && $user->dpw > 0 ){
            $studentCanDriveGtThisWeek=$user->hours->keyBy('drive.date')->sortByDesc('drive.date')->filter( function ($hour, $key) {
                return $key > Carbon::parse('last week 0:00');//change to last week
            });
            for ($i=0; $i < 4; $i++) { 
                $tmp[$i] = $studentCanDriveGtThisWeek->filter( function ($item, $key) use ($i){
                    $week = Carbon::parse('this week 0:00')->addWeeks($i);
                    return $key > $week && $key < $week->addWeeks(1);
                });
                $studentCanDriveGtThisWeek = $studentCanDriveGtThisWeek->diff($tmp[$i])->keyBy('drive.date');
                $tmp[$i] = $user->dpw - $tmp[$i]->count();
            }
            $studentCanDrive = $tmp;
            $user->canDrive = $tmp;
            $instructors = Role::whereName('instructor')->with(['users.attrs','users.drives' => function($query){$query->where('date', '>', date('Y-m-d', strtotime('this week')));},'users.drives.hours.user'])->get()[0]['users'];
            //$instructors->drives->load('hours');
            //dd($instructors);
            foreach ($instructors as $key => $instructor) {
                $sorted = $instructor->drives->keyBy('date');
                for ($i=0; $i < 4; $i++) { 
                    $drivesTW[$i] = $sorted->filter( function ($item, $key) use ($i){
                        $week = Carbon::parse('this week 0:00')->addWeeks($i);
                        return $key > $week && $key < $week->addWeeks(1);
                    });
                    $sorted = $sorted->diff($drivesTW[$i])->keyBy('date');
                }
                $instructor->drives = collect($drivesTW);
            }
            //dd($studentCanDrive,$instructors);
        }
        //dd($id,$user,$payments,$paymentsList,$costNames);
        //dd($user);
        return view('user.show', compact('user','costNames','payed','instructors'));
    }

    public function show_instructor($id)
    {
        $user = User::whereId($id)->with('attrs','drives.hours.user')->first();
        $drives = $user->drives->sortByDesc('date');
        $students = Role::whereName('Student')->with('users.attrs','users.payments','users.hours')->get()[0]['users']->keyBy('id')->sortBy('id');
        $drives = collect($this->drivesInWeek($drives));
        $students = $students->filter(function ( $student, $key ) {
            return $student->hours->sum('count')+$student->attrs->values['old_hours'] < $student->attrs->values['hours']; 
        });
        $drivesPerWeek = collect([200,500,1000]);
        
        $studentsDrivesPerWeek = $students->map( function( $item, $key) use ($drivesPerWeek) {
            $payed = $item->payments->groupBy('payment_for')->map(function ($item, $key){
                return $item->sum('amount');
            });
            if(isset($payed['course'])){
                return $drivesPerWeek->filter( function ($item, $key) use ($payed) {
                    return $item <= $payed['course'];
                })->count();    
            }else{
                return 0;
            }
        });

        for ($i=0; $i < 4; $i++) { 
            $cantDriveList[$i] = clone $studentsDrivesPerWeek; 
        }

        for ($i=0; $i < 4; $i++) { 
            $drivesInWeek[$i] = Drive::where('date', '>', Carbon::parse('this week 0:00')->addWeeks($i))->where('date', '<', Carbon::parse('this week 0:00')->addWeeks($i+1))->with('hours')->get()->keyBy('date');
        }
        //dump("canDriveList item ",$cantDriveList);
        //dump("drivesInWeek item ",$drivesInWeek);
        //dd($drivesInWeek);
        collect($drivesInWeek)->each( function ( $item, $key) use ($cantDriveList) {
            $list = $cantDriveList[$key];
            //dump($list);
            //dump("drivesInWeek item ",$item);
            $item->each( function ( $item, $key) use ( $list) {
            //dump("key ",$key);
            //dump("item->hours->keyBy ",$item->hours->keyBy('user_id'));
                $item->hours->keyBy('user_id')->each( function ( $item, $key) use ($list) {
                        //dump($key);
                        //dump($item);
                    if( isset( $list[$key])) {   
                        //dump($key);
                        //dump($list[$key]);
                        $list[$key]-=1;
                        //dump($list[$key]);
                    }
                });
            });
            $cantDriveList[$key] = $list;
        });
        //dump("cantDriveList",$cantDriveList);
        foreach ($cantDriveList as &$cdl) {
            $cdl = $cdl->filter( function ( $item) {
                return $item <= 0;
            });
        }
        //dump("cantDriveList",$cantDriveList);
        //dump("students",$students);
        for ($i=0; $i < 4; $i++) { 
            $s = clone $students;
            $canDriveList[$i] = $s->forget($cantDriveList[$i]->keys()->all())->pluck('name', 'id');
        }
        $canDriveList['old'] = $students->pluck('name','id');
        //dd($students,$studentsDrivesPerWeek,$cantDriveList,$canDriveList,$drives);
        $user->drives = $drives;
        return view('user.show_instructor', compact('user','students','studentsDrivesPerWeek','canDriveList'));
    }

    public function show_admin($admin)
    {
        
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
    public function update(Request $request, User $user)
    {
        $data = $request->all();
        $this->validator($data)->validate();
        $user->load('attrs');
        $user->fill($data);
        $user->attrs->fill($data['attrs']);//add ->save() 
        return response()->json([$data,$user]);
        $user->attrs->fill($data)->save();
        //dump($user);
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
    public function destroy(User $user)
    {
        return response()->json([
            'status' => 'success',
            'message' => "User $user->name delete",
            'data' => $user
        ]);
    }

    protected function drivesInWeek( $items )
    {
        for ($i=3; $i >= 0; $i--) {
            $item[$i] = $items->keyBy('date')->filter( function( $item, $key) use ( $i) {
                return $key > Carbon::parse('this week 0:00')->addWeeks($i) && $key < Carbon::parse('this week 0:00')->addWeeks($i+1);
            });
            $items = $items->diff($item[$i])->keyBy('date');
        }
        $item['old'] = $items;
        return $item;
    }
}
