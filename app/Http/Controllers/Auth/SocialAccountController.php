<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SocialAccountController extends Controller
{
    public function redirectToProvider($provider){
        return \Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback(\App\SocialAccountService $accountService, Request $request, $provider){
        try{
            $user=\Socialite::with($provider)->user();
            
            /*simpan tokennya di session */
            if($request->session()->has('token_'.$provider)){
                $request->session()->forget('token_'.$provider,$user->token);

                $request->session()->put('token_'.$provider,$user->token);
            }else{
                $request->session()->put('token_'.$provider,$user->token);
            }
            /*end save token */

        }catch(\Exception $e){
            return redirect('/login');
        }

        $authUser=$accountService->findOrCreate($user,$provider);

        auth()->login($authUser,true);


        return redirect()->to('sosmed/connect/'.$provider);
    }
}
