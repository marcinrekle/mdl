<?php

namespace App\Http\Controllers;

use App\Hour;
use App\Drive;
use App\User;
use App\Role;
use Validator;
use Illuminate\Http\Request;

class HourController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hours = Hour::with(['user','drive.user'])->get();
        //dd($hours);
        return view('hour.index', compact('hours'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //$drive = Drive::where('date','>',Carbon::now());
        $drive = Drive::with(['user','hours'])->get();
        //dump($drive);
        $drive = $drive->filter(function ($item, $key){
            return $item->hours->sum('count') < $item->hours_count;
        });
        $drive = $drive->mapWithKeys(function ($item){
            //return  [$item->id => "$item->date - {$item->user->name}"];
            return  [$item->id => "$item->date - {$item->user->name}"];
        });
        //dd($drive);
        $user = Role::find(4)->users->pluck('name', 'id');
        return view('hour.create', compact('drive', 'user'));
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
        if($validator->fails()) return response()->json($validator->messages(),422);
        //if($validator->fails()) return redirect()->back()->withErrors($validator)->withInput();
        $hour = Hour::create($data);
        return response()->json(['hour' => $hour,'msg' => 'Dodano godziny'],200);
        //return redirect()->back()->withSuccess('Dodano kursanta do jazdy');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Hour  $hour
     * @return \Illuminate\Http\Response
     */
    public function show(Hour $hour)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Hour  $hour
     * @return \Illuminate\Http\Response
     */
    public function edit(Hour $hour)
    {
        $drive = $hour->drive;
        //dd($drive->hours->pluck('user_id','id'));
        $drive = [$drive->id => "$drive->date - {$drive->user->name}"];
        $user = Role::find(4)->users->pluck('name', 'id');
        return view('hour.edit', compact('hour', 'drive','user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Hour  $hour
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Hour $hour)
    {
        $data = $request->all();
        $validator = $this->validator($data);
        //if($validator->fails()) return redirect()->back()->withErrors($validator)->withInput();
        if($validator->fails()) return response()->json($validator->messages(),422);
        $unique = Hour::where([['user_id',$data['user_id']],['drive_id',$data['drive_id']]])->get();
        if($unique[0]->id!=$hour->id) return response()->json(['msg'=>'Nie można dodać drugi raz'],422);
        //if($unique) return redirect()->back()->withErrors('Kursant już bierze udział w tej jeździe')->withInput();
        //if($unique) return response()->json(['msg'=>'Nie można dodać drugi raz'],422);
        $hour->update($data);
        return response()->json(['hour' => $hour,'msg' => 'Aktualizacja zakończona sukcesem'],200);
        //return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Hour  $hour
     * @return \Illuminate\Http\Response
     */
    public function destroy(Hour $hour)
    {
        //
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            //'user_id'    => 'required|exists:users,id|unique:hours,user_id,NULL,id,drive_id,'.$data['drive_id'],
            'user_id'    => 'required|exists:users,id',
            'count'  => 'required|numeric|min:0|max:8',
            //'drive_id'    => 'required|exists:users,id|unique:hours,drive_id,NULL,id,user_id,'.$data['user_id'],
            'drive_id'    => 'required|exists:drives,id',
        ]);
    }
}
