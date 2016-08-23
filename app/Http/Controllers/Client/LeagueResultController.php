<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Repositories\League\LeagueRepositoryInterface;

class LeagueResultController extends Controller
{
    private $leagueRepository;

    public function __construct(LeagueRepositoryInterface $leagueRepository)
    {
        $this->leagueRepository = $leagueRepository;
    }

    public function index($leagueId)
    {
        $result = $this->leagueRepository->result($leagueId);

        if (isset($result['error'])) {
            return redirect()->route('home')->withError($result['error']);
        }

        return view('client.league.result', compact('result'));
    }
}
