<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use App\Repositories\User\UserRepositoryInterface;
use Validator;
use Exception;

class UserController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = $this->userRepository->show($id);

        return view('user.show', [
            'user' => $user,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if ($id != Auth::user()->id) {
            return redirect()->route('user.profiles.show', $id)->withErrors(trans('message.not_permission'));
        }

        return view('user.edit', ['user' => Auth::user()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $validator = Validator::make($request->all(), $request->rules());

        if ($validator->fails()) {
            return redirect()->route('user.profiles.show', $id)->withErrors($validator);
        }

        $user = $this->userRepository->updateInfo($request);

        if (isset($user['error'])) {
            return redirect()->back()->withErrors($user['error']);
        }

        return redirect()->route('user.profiles.show', $id)->with(['message' => trans('message.update_user_success')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getChangePassword($id)
    {
        $user  = Auth::user();

        if ((empty($user->password)) || ($id != $user->id)) {
            return redirect()->route('user.profiles.show', $id)->withErrors(trans('message.not_permission'));
        }

        return view('user.edit_password', ['user' => $user]);
    }

    public function postChangePassword(ChangePasswordRequest $request, $id)
    {
        if ($id != Auth::user()->id) {
            return redirect()->route('user.profiles.show', $id)->withErrors(trans('message.not_permission'));
        }

        $user = $this->userRepository->changePassword($request);

        if (isset($user['error'])) {
            return redirect()->back()->withErrors($user['error']);
        }

        Auth::login($user);

        return redirect()->route('user.profiles.show', $id)->with(['message' => trans('message.change_password_success')]);
    }
}
