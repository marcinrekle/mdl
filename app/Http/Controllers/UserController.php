<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Field;
use App\Role;

use Validator;
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
        //dd(User::find($id)->with('attrs')->first());
        if( is_numeric($id) ){
            $user = User::whereId($id)->with('attrs','payments','hours.drive')->first();
            //$paymentsList = $user->payments;
            $payed = $user->payments->groupBy('payment_for')->map(function ($item, $key){
                return $item->sum('amount');
            });
            //dd(isset($payed['course']));
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
                    $tmp[$i] = $tmp[$i]->count();
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
        $users = Role::whereName($id)->with('users.attrs')->get()[0]['users'];
        //dd($users);
        $role = $id;
        return view('user.role_show', compact('users','role'));
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
