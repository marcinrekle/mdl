<?php

namespace App\Http\Controllers;

use App\Payment;
use App\User;
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
        $payments = Payment::with('user')->get();
        return view('payment.index', compact('payments'));
        //dd($payments);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($user_id = null)
    {
        //$user_id = 4;
        $user = $user_id ? [$user_id => User::find($user_id)->pluck('name')->first()] : User::all()->pluck('name', 'id');
        $payment_for = ['course' => 'Za kurs', 'doctor' => 'Za lekarza'];
        //dd($user);
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
        return redirect()->route('payment.index')->withSuccess('Dodano płatność');
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
        $payment_for = ['course' => 'Za kurs', 'doctor' => 'Za lekarza'];
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
}
