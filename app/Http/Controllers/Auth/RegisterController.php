<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Role;
use Auth;
use App\Mail\emailConfirmation;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:user-create');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'avatar' => '/img/defaultUser.png',
            'confirm_code' => str_random(32),
            'status' => $data['status'],
        ]);
        $user->attrs()->create(['values' => $data['values']]);
        $role = Role::whereName($data['role'])->first();
        $user->attachRole($role);
        return $user;
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $data = $this->create($request->all());
        $user = User::findOrFail($data['id']);

        Mail::to($user->email)->send(new emailConfirmation($user));

        return $this->registered($request, $user)
                        ?: redirect($this->redirectPath());
    }

    public function confirm(Request $request, $code)
    {
        //if(!Auth::guest()) return redirect('/home');
        $user = User::where('confirm_code', $code)->first();
        if ($user) {
            if ($user->confirmed) {
                return redirect('/home')->withInfo("To konto jest już potwierdzone");
            }
            $request->session()->put(['cuid' => $user->id, 'ccode' => $code]);
            return view('auth.confirm')->with(
                ['code' => $code]
            );
        }
        return redirect('/home')->withInfo("Kod weryfikacyjny jest niepoprawny");
    }

    public function confirmSetPassword(Request $request)
    {
        $code = $request->session()->pull('ccode', null);
        $uid = $request->session()->pull('cuid', null);
        
        if( !$code || !$uid ){
            return redirect()->back()->withErrors('Wystąpił błąd odswież stronę');
        }
        
        $user = User::whereId($uid)->where('confirm_code', $code)->first();
        
        if ($user) {
            if ($user->confirmed) {
                return redirect('/')->withErrors("To konto jest już potwierdzone");
            }

            $user->confirmed = 1;
            $user->password = bcrypt($request->password);
            $user->save();
            Auth::login($user, true);
            return redirect('/')->route('confirmedEmail')->withSuccess("To konto zostało potwierdzone");
        }
        return redirect('/')->withErrors("Nie posiadasz u nas konta. Skontaktuj sie z administratorem");
    }

    public function confirmed()
    {
        return view('auth.confirmed');
    }
       
}
