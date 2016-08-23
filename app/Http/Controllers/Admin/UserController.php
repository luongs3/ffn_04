<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\AdminUpdateUserRequest;
use App\Http\Controllers\Controller;
use App\Repositories\User\UserRepositoryInterface;
use Validator;
use App\Models\User;
use Session;

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
        $users = $this->userRepository->allUser();
        $optionRole = $this->userRepository->optionRole();
        $optionActive = $this->userRepository->optionActive();

        return view('admin.user.index', [
            'users' => $users,
            'optionRole' => $optionRole,
            'optionActive' => $optionActive,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $optionRole = $this->userRepository->optionRole();

        return view('admin.user.create', ['optionRole' => $optionRole]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUserRequest $request)
    {
        $validator = Validator::make($request->all(), $request->rules());

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $confirmationCode = str_random(config('common.user.confirmation_code.length'));

        try {
            $user = $this->userRepository->adminCreate($request, $confirmationCode);
        } catch (Exception $e) {
            return redirect()->route('admin.users.index')->withError($e->getMessage());
        }

        return redirect()->route('admin.users.index')->with(['message' => trans('message.register_active')]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = $this->userRepository->find($id);
        $optionRole = $this->userRepository->optionRole();
        $optionActive = $this->userRepository->optionActive();

        return view('admin.user.show', [
            'user' => $user,
            'optionRole' => $optionRole,
            'optionActive' => $optionActive,
            'message' => isset($user['error']) ? $user['error'] : '',
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
        $user = $this->userRepository->find($id);
        $optionRole = $this->userRepository->optionRole();

        return view('admin.user.edit', [
            'user' => $user,
            'optionRole' => $optionRole,
            'message' => isset($user['error']) ? $user['error'] : '',
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminUpdateUserRequest $request, $id)
    {
        $validator = Validator::make($request->all(), $request->rules());

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $user = $this->userRepository->adminUpdate($request, $id);

        if (isset($user['error'])) {
            return redirect()->back()->withErrors($user['error']);
        }

        return redirect()->route('admin.users.index')->with(['message' => trans('message.update_user_success')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (request()->has('ids')) {
            $ids = request()->get('ids');
        }

        $data = $this->userRepository->destroy($ids);

        if (isset($data['errors'])) {
            session()->flash('error', $data['errors']['message']);

            return response()->json(['success' => false, 'ids' => []]);
        }

        return response()->json(['ids' => $ids]);
    }
}
