<?php

namespace App;

use Laravel\Socialite\Contracts\User as ProviderUser;

class SocialAccountService
{
    public function findOrCreate(ProviderUser $providerUser,$provider)
    {
        $account=LinkedSocialAccount::where('provider_name',$provider)
            ->where('provider_id',$providerUser->getId())
            ->first();

        if($account){
            return $account->user;
        }else{
            $user=User::find(auth()->user()->id);

            $user->accounts()->create(
                [
                    'provider_id'=>$providerUser->getId(),
                    'provider_name'=>$provider
                ]
            );

            return $user;
        }
    }
}