<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use Auth;
use App\Repositories\User\UserRepositoryInterface;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';
    protected $userRepository;
    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
        $this->userRepository = $userRepository;
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
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    public function getLogin()
    {
        return view('auth.login');
    }

    public function postLogin(LoginRequest $request)
    {
        $validator = Validator::make($request->all(), $request->rules());

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $email = $request->input('email');
        $password = $request->input('password');

        if (Auth::attempt(['email' => $email, 'password' => $password, 'confirmed' => config('common.user.confirmed.is_confirm')], $request->has('remember'))) {

            if (Auth::user()->isAdmin()) {
                return redirect()->route('admin.users.index');
            }

            return redirect('/home');
        } else {
            return redirect()->back()->withErrors(trans('message.login_error'));
        }
    }

    public function getRegister()
    {
        return view('auth.register');
    }

    public function postRegister(RegisterRequest $request)
    {
        return $this->register($request);
    }

    public function register(RegisterRequest $request)
    {
        $validator = Validator::make($request->all(), $request->rules());

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $confirmationCode = str_random(config('common.user.confirmation_code.length'));

        try {
            $user = $this->userRepository->create($request, $confirmationCode);
        } catch (Exception $e) {
            return redirect('/home')->withError($e->getMessage());
        }

        return redirect()->back()->withErrors(trans('message.register_active'));
    }

    public function confirm($confirmationCode)
    {
        try {
            $user = $this->userRepository->updateConfirm($confirmationCode);
            Auth::login($user);

            if (Auth::user()->isAdmin()) {
                return redirect()->route('admin.users.index');
            }

            return redirect('/');
        } catch (Exception $e) {
            return redirect('/')->withError($e->getMessage());
        }
    }
}
