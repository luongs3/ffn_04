<?php
namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Repositories\Message\MessageRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;

class AjaxMessageController extends Controller
{
    private $messageRepository;
    private $userRepository;

    public function __construct(
        MessageRepositoryInterface $messageRepository,
        UserRepositoryInterface $userRepository
    ) {
        $this->messageRepository = $messageRepository;
        $this->userRepository = $userRepository;
    }

    public function update($id)
    {
        $requestData = request()->get('data');
        $data = $this->messageRepository->update($requestData, $id);

        if (isset($data['error'])) {
            return response()->json(['success' => false]);
        }

        return response()->json(['success' => true]);
    }
}
