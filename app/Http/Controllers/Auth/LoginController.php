<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

use Socialite;

use App\User;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return Response
     */
    public function redirectToProvider(Request $request, $provider=null)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function handleProviderCallback(Request $request, $provider=null)
    {
        $user = Socialite::driver($provider)->user();
        $authUser = $this->findOrConnectUser($request, $user);
        Auth::login($authUser, true);
        //dd($user);
        // $user->token;
    }

    /**
     * Return user if exists; connect and return if doesn't
     *
     * @param $socialUser
     * @return User
     */
    public function findOrConnectUser(Request $request, $socialUser)
    {
        //var_dump(session()->all());
        //dd($request->session()->all());
        $authUser = User::where('social_id', $socialUser->id)->first();
        //var_dump($authUser);
        
        if ($authUser){
            //return $authUser;
        }
        $uid = $request->session()->pull('cuid')  ? :Auth::user()->id;
        $user = User::whereId($uid)->first();
        if($user){
            $user->social_id = $socialUser->id;
            $user->avatar = $socialUser->avatar;
            $user->confirmed = true;//change - remove comment
            $user->save();
            return $user;
        }
        return redirect('/')->withErrors("Niestety nie posiadasz u nas konta");


    }
}
