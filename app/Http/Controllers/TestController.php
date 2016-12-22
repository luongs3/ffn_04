<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp;
use App\Http\Requests;

class TestController extends Controller
{
    public function test()
    {
        return view('test');
    }

    public function testCallback($provider, $resourceId)
    {
        $http = new GuzzleHttp\Client;
        $response = $http->post('http://local-pets.com/oauth/token', [
            'form_params' => [
                'grant_type' => 'authorization_code',
                'client_id' => 9,
                'client_secret' => 'UrXxD88XHrbCdhiM6dlwP9GyypPKII4NsE76juLZ',
                'redirect_uri' => 'http://local-football.com/testCallback/' . $provider . '/' . $resourceId,
                'code' => request()->code,
            ],
        ]);

        $authorizationData = json_decode((string) $response->getBody(), true);
    }
}
