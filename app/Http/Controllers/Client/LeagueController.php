<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Repositories\League\LeagueRepositoryInterface;
use App\Repositories\Post\PostRepositoryInterface;
use Carbon\Carbon;

class LeagueController extends Controller
{
    private $leagueRepository;
    private $postRepository;

    public function __construct(
        LeagueRepositoryInterface $leagueRepository,
        PostRepositoryInterface $postRepository
    ) {
        $this->leagueRepository = $leagueRepository;
        $this->postRepository = $postRepository;
    }

    public function show($id)
    {
        $league = $this->leagueRepository->show($id);

        if (isset($league['error'])) {
            return route('home')->withError($league['error']);
        }

        $posts = $this->postRepository->index();

        if (isset($posts['error'])) {
            return route('home')->withError($posts['error']);
        }

        return view('client.league.show', compact('league', 'posts'));
    }
}
