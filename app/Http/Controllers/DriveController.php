<?php

namespace App\Http\Controllers;

use App\Drive;
use App\Role;
use App\User;
use App\Hour;
use Validator;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DriveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$drives = Drive::with(['hours'])->get()->sortBy('date')->groupBy([function ($item) {return Carbon::parse($item->date)->format('Y-m-d');},'user_id',function ($item) {return Carbon::parse($item->date)->format('H:i');}]);
        //$drives = Drive::with(['hours'])->get()->sortBy('date')->groupBy([function ($item) {return Carbon::parse($item->date)->format('Y-m-d');},'user_id',function ($item) {return Carbon::parse($item->date)->format('H:i');}]);
        $drives = Drive::with(['hours'])->get()->map(function ($drive) {$drive['day'] = Carbon::parse($drive->date)->format('Y-m-d');$drive['time'] = Carbon::parse($drive->date)->format('H:i');return $drive;})->sortBy(['date'])->values()->all();
        //dd($drives);
        return response()->json(['drives' => $drives]);
        //return view('drive.index', compact('drives'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($user_id = null)
    {
        $user = Role::find(3)->users->pluck('name', 'id');
        //dd($user);
        return view('drive.create', compact('user'));
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
        $unique = Drive::where([['user_id',$data['user_id']],['date',$data['date']]])->count();
        if($unique>0) response()->json(['msg' => 'O tej godzinie już istnieje jazda']);
        if($validator->fails()) response()->json(['validator' => $validator]);
        $drive = Drive::create($data);
        //$drive = new Drive;
        //$drive->fill($data)->save();
        $hours = [];
        foreach ($data['s_user_id'] as $key => $user_id) {
            $hours[] = new Hour(['user_id'=>$user_id]);
        }
        $drive->hours()->saveMany($hours);
        return response()->json(['drive' => $data,'validator' => $validator,'msg' => 'Dodano nową jazde']);
        //return redirect()->route('drive.index')->withSuccess('Dodano jazdę');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Drive  $drive
     * @return \Illuminate\Http\Response
     */
    public function show(Drive $drive)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Drive  $drive
     * @return \Illuminate\Http\Response
     */
    public function edit(Drive $drive, $user_id = null)
    {
        //$user = $user_id ? [$user_id => User::find($user_id)->pluck('name')->first()] : User::all()->pluck('name', 'id');
        $user = Role::find(3)->users->pluck('name', 'id');
        return view('drive.edit', compact('drive','user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Drive  $drive
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Drive $drive)
    {
        $data = $request->all();
        $validator = $this->validator($data);
        //if($validator->fails()) return redirect()->back()->withErrors($validator)->withInput();
        if($validator->fails()) response()->json(['validator' => $validator]);
        $drive->update($data);
        $hours = [];
        foreach ($data['s_user_id'] as $key => $user_id) {
            $hours[] = new Hour(['user_id'=>$user_id]);
        }
        $drive->hours()->updateOrCreateMany($hours);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Drive  $drive
     * @return \Illuminate\Http\Response
     */
    public function destroy(Drive $drive)
    {
        //
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'user_id'    => 'required|exists:users,id',
            'date'  => 'required|date_format:Y-m-d H:i',
            'hours_count'  => 'required|numeric|min:0.5|max:8',
            //'user_id' => ['required', 'unique:drives,user_id,NULL,id,date,'.$data['date']],
        ]);
    }
}
