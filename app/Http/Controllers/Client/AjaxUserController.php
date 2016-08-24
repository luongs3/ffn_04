<?php
namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Repositories\User\UserRepositoryInterface;

class AjaxUserController extends Controller
{
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function update($id)
    {
        $requestData = request()->get('data');
        $data = $this->userRepository->update($requestData, $id);

        if (isset($data['error'])) {
            return response()->json(['success' => false]);
        }

        return response()->json(['success' => true]);
    }
}
