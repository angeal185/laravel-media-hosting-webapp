<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\User;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Socialite;

class SocialController extends Controller
{
    /**
     * Redirect the user to the Facebook authentication page.
     *
     * @return Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Obtain the user information from Facebook.
     *
     * @return Response
     */
    public function handleProviderCallback()
    {
        $user = Socialite::driver('facebook')->user();

        $authUser = $this->findOrCreateUser($user);

        Auth::login($authUser, true);

        return redirect ('/');
    }

    /**
     * Return user if exists; create and return if doesn't
     *
     * @param $fbUser
     * @return User
     */
    private function findOrCreateUser($fbUser)
    {

        if ($authUser = User::where('facebook_id', $fbUser->id)->first()) {
            return $authUser;
        }

        return User::create([
            'username' => $fbUser->name,
            'email' => $fbUser->email,
            'facebook_id' => $fbUser->id,
            'avatar' => $fbUser->avatar,
        ]);

    }
}