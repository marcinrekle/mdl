<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Field;
use App\Role;
use App\Drive;

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
        $users = User::with('attrs')->get();//get all active users
        return view('user.index', compact('users'));
        //dd($users);
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
        return view('user.role_show', compact('users','role'));
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
