<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Auth;
use App\Repositories\Post\PostRepositoryInterface;

class HomeController extends Controller
{
    protected $postRepository;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = $this->postRepository->index();

        return view('home', ['posts' => $posts]);
    }

    public function getLogout()
    {
        Auth::logout();

        return redirect(\URL::previous());
    }
}
