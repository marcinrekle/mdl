<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;
use JWTFactory;
use JWTAuth;

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
        $this->middleware('guest', ['except' => ['logout', 'user']]);
    }

    /**
     * Login user.
     *
     * @return Response
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email','password');
        if ( ! $token = JWTAuth::attempt($credentials)) {
            return response([
                'status' => 'error',
                'error' => 'invalid.credentials',
                'msg' => 'Invalid Credentials.'
            ], 400);
        }
        //$user = auth::user();
        return response()->json([
            'message' => 'Successfully logged in',
            //'user'   => $user,
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => 3600
        ])->header('Authorization', "Bearer ".$token);
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        JWTAuth::invalidate();
        return response([
            'status' => 'success',
            'msg' => 'Logged out Successfully.'
        ], 200);
    }

    public function refresh(Request $request)
    {
        return response()->json([
            'status' => 'refresh',
        ]);
    }

    public function user()
    {
        $user = auth()->user();
        return response()->json([
            'status' => 'success',
            'data' => $user
        ]);
    }

    /**
     * Redirect the user to the provider authentication page.
     *
     * @return Response
     */
    public function redirectToProvider(Request $request, $provider=null)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from provider.
     *
     * @return Response
     */
    public function handleProviderCallback(Request $request, $provider=null)
    {
        $user = Socialite::driver($provider)->user();
        $authUser = $this->findOrConnectUser($request, $user);
        Auth::check() ? :Auth::login($authUser, true);
        return redirect('/');
    }

    /**
     * Return user if exists; connect and return if doesn't
     *
     * @param $socialUser
     * @param $request
     * @return User
     */
    public function findOrConnectUser(Request $request, $socialUser)
    {
        $authUser = User::where('social_id', $socialUser->id)->first();
        if ($authUser){
            return $authUser;
        }

        $user = User::whereId($request->session()->pull('cuid', 'default'))->where('confirm_code', $request->session()->pull('ccode', 'default'))->whereConfirmed(false)->first();
        
        if($user){
            $user->social_id = $socialUser->id;
            $user->avatar = $socialUser->avatar;
            $user->password = bcrypt('znatylkosu');
            $user->confirmed = 1;
            $user->save();
            Auth::login($user, true);
            return redirect()->route('confirmedEmail')->withSuccess('Konto zostało potwierdzone.');
        }
        return redirect('/')->withErrors("Niestety nie posiadasz u nas konta.");
    }
}
