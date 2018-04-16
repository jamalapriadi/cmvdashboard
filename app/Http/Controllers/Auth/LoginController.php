<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

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
        $this->middleware('guest')->except('logout');
    }

    protected function hasTooManyLoginAttempts(Request $request){
        $maxLoginAttempts=3;

        $lockoutTime=1; // dalam menit

        return $this->limiter()->tooManyAttempts(
            $this->throttleKey($request),$maxLoginAttempts,$lockoutTime
        );
    }

    protected function sendLoginResponse(Request $request){
        $request->session()->regenerate();
        $previous_session=auth()->user()->session_id;
        if($previous_session){
            \Session::getHandler()->destroy($previous_session);
        }

        auth()->user()->session_id=\Session::getId();
        auth()->user()->status_login="On";
        auth()->user()->save();

        $this->clearLoginAttempts($request);

        return $this->authenticated($request, $this->guard()->user())
            ?: redirect()->intended($this->redirectPath());
    }

    protected function credentials(Request $request){
        return $request->only($this->username(),'password','status_active');
    }

    protected function attemptLogin(Request $request){
        $request->merge(['status_active','Y']);

        return $this->guard()->attempt(
            $this->credentials($request),$request->filled('remember')
        );
    }

    public function setPasswordAttribute($password)
    {   
        $this->attributes['password'] = bcrypt($password);
    }

    public function logout(Request $request){
        auth()->user()->status_login="Off";
        auth()->user()->save();
        auth()->logout();
        return redirect('/');
    }
}
