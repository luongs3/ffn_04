<?php
namespace App\Http\Controllers\Auth;
/**
 * Created by PhpStorm.
 * User: james
 * Date: 17/10/2016
 * Time: 16:30
 */
use App\Http\Controllers\Controller;
use App\Models\SocialAcount;
use App\Models\User;
use Auth;
use GuzzleHttp;
use Request;

class OAuthController extends Controller {
    public function redirect($provider)
    {
        // from provider. Get client_id from table "provider"
        $query = http_build_query([
            'client_id' => 9,
            'redirect_uri' => 'http://local-football.com/openAuth/' . $provider . '/callback',
            'response_type' => 'code',
            'scope' => 'collaborative-doctor',
        ]);

        return redirect('http://local-pets.com/oauth/authorize?'.$query);
    }

    public function callback($provider) {
        // get client_id and client_secret
        $http = new GuzzleHttp\Client;
        $response = $http->post('http://local-pets.com/oauth/token', [
            'form_params' => [
                'grant_type' => 'authorization_code',
                'client_id' => 9,
                'client_secret' => 'UrXxD88XHrbCdhiM6dlwP9GyypPKII4NsE76juLZ',
                'redirect_uri' => 'http://local-football.com/openAuth/' . $provider . '/callback',
                'code' => request()->code,
            ],
        ]);
        $authorizationData = json_decode((string) $response->getBody(), true);
        $http = new GuzzleHttp\Client;
        $response = $http->get('http://local-pets.com/api/user', [
            'headers' => [
                'accept' => 'application/json',
                'authorization' => 'Bearer ' . $authorizationData['access_token'],
            ],
        ]);
        $providersUser = json_decode ( $response->getBody(), true);
        $data = [
            'name' => $providersUser['name'],
            'email' => $providersUser['email'],
        ];

        $user = User::firstOrCreate($data);

        $socialData = [
            'user_id' => $user->id,
            'type' => $provider,
            'social_user_id' => $providersUser['id'],
        ];

        SocialAcount::firstOrCreate($socialData);
        $cookieName = "userAccessToken_" . $provider . "_" . $user->id;
        \Cookie::make($cookieName, $authorizationData['access_token'], time()+360000, '/');
//        setcookie($cookieName, $authorizationData['access_token'], time()+360000, '/');
        Auth::login($user);
        return redirect('/home');
    }
}