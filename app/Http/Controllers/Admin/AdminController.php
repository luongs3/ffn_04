<?php
namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\Post\PostRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Carbon\Carbon;

class AdminController extends Controller
{
    protected $userRepository;
    protected $postRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        PostRepositoryInterface $postRepository
    ) {
        $this->userRepository = $userRepository;
        $this->postRepository = $postRepository;
    }

    public function index()
    {
        $user = $this->userRepository->userStatistic();

        if (isset($user['error'])) {
            return redirect()->route('home')->withError($user['error']);
        }

        $posts = $this->postRepository->getRecentPosts();

        return view('admin.admin.index', compact('user', 'posts'));
    }
}
