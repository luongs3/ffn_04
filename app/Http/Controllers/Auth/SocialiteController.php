<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Socialite;
use App\Models\User;
use App\Models\SocialAccount;
use Auth;
use App\Repositories\User\UserRepositoryInterface;

class SocialiteController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function redirectToProvider($social)
    {
        return Socialite::driver($social)->redirect();
    }

    public function handleProviderCallback($social)
    {
        $socialUser = Socialite::driver($social)->user();

        if ($socialUser) {
            try {
                $user = $this->userRepository->createSocialUser($socialUser, $social);
                Auth::login($user);
            } catch (Exception $e) {
                return redirect('/home')->withError($e->getMessage());
            }
        }

        return redirect('/home');
    }
}
