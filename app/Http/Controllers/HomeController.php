<?php

namespace App\Http\Controllers;

use App\Repositories\Match\MatchRepositoryInterface;
use Auth;
use App\Repositories\Post\PostRepositoryInterface;

class HomeController extends Controller
{
    protected $postRepository;
    protected $matchRepository;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        PostRepositoryInterface $postRepository,
        MatchRepositoryInterface $matchRepository
    ) {
        $this->postRepository = $postRepository;
        $this->matchRepository = $matchRepository;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = $this->postRepository->index();

        $recentMatches = $this->matchRepository->getHomeViewMatches();

        return view('home', ['posts' => $posts, 'recentMatches' => $recentMatches]);
    }

    public function getLogout()
    {
        Auth::logout();

        return redirect(\URL::previous());
    }
}
