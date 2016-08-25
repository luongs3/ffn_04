<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\AdminMessage\AdminMessageRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class AjaxAdminMessageController extends Controller
{
    private $adminMessageRepository;
    private $userRepository;

    public function __construct(
        AdminMessageRepositoryInterface $adminMessageRepository,
        UserRepositoryInterface $userRepository
    ) {
        $this->adminMessageRepository = $adminMessageRepository;
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        $adminMessages = $this->adminMessageRepository->all();

        if (isset($adminMessages['error'])) {
            return response()->json(['error' => ($adminMessages['error'])]);
        }

        $user = $this->userRepository->show(Auth::user()->id);

        if (isset($user['error'])) {
            return response()->json(['error' => ($user['error'])]);
        }

        $data = [
            'messages' => $adminMessages,
            'user' => $user,
        ];

        return response()->json($data);
    }

    public function update($id)
    {
        $requestData = request()->get('data');
        $data = $this->adminMessageRepository->update($requestData, $id);

        if (isset($data['error'])) {
            return response()->json(['success' => false]);
        }

        return response()->json(['success' => true]);
    }
}
