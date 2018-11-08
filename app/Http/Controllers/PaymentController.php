<?php

namespace App\Http\Controllers;

use App\Payment;
use App\User;
use App\Role;
use App\Field;
use Validator;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payments = Payment::with('user')->get()->sortBy('payment_date');
        $costNames = $this->getCostNames();
        return response()->json(['payments' => $payments, 'costNames' => $costNames]);
        return view('payment.index', compact('payments','costNames'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //$user_id = 4;
        //$user = $user_id ? [$user_id => User::find($user_id)->pluck('name')->first()] : User::all()->pluck('name', 'id');
        $user = Role::whereName('student')->get()[0]['users']->sortBy('name')->pluck('name','id');
        $payment_for = $this->getCostNames();
        return view('payment.create',compact('user', 'payment_for'));
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
        $payment = Payment::create($data);
        return response()->json(['payment' => $payment,'msg' => 'Dodano nową wpłate']);
        //return redirect()->route('payment.index')->withSuccess('Dodano płatność');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function edit(Payment $payment, $user_id = null)
    {
        //dd($payment);
        $user = $user_id ? [$user_id => User::find($user_id)->pluck('name')->first()] : User::all()->pluck('name', 'id');
        $payment_for = $this->getCostNames();
        return view('payment.edit', compact('payment','payment_for','user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payment $payment)
    {
        $data = $request->all();
        $validator = $this->validator($data);
        if($validator->fails()) return redirect()->back()->withErrors($validator)->withInput();
        $payment->update($data);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment)
    {
        $payment->delete();
        return redirect()->back();
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'user_id'    => 'required|exists:users,id',
            'payment_date'  => 'required|date',
            'payment_for'  => 'required|in:course,doctor',
            'amount'        => 'required|numeric|min:10|max:5000',
        ]);
    }

    protected function getCostNames(){
        $costNames = Field::where("name","like",'%cost%')->orderBy('name')->get();
        return $costNames->map( function($item, $key) {
            $item->name = str_replace("cost_", '', $item->name);
            return $item;
        })->pluck('slug','name');
    }
}
