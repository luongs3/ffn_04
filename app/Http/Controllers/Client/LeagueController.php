<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Repositories\League\LeagueRepositoryInterface;
use Carbon\Carbon;

class LeagueController extends Controller
{
    private $leagueRepository;

    public function __construct(LeagueRepositoryInterface $leagueRepository)
    {
        $this->leagueRepository = $leagueRepository;
    }

    public function rank($leagueId)
    {
        $rank = $this->leagueRepository->rank($leagueId);

        if (isset($rank['error'])) {
            return redirect()->route('home')->withErrors($rank['error']);
        }

        return view('client.league.rank', compact('rank'));
    }

    public function schedule($leagueId)
    {
        $schedule = $this->leagueRepository->schedule($leagueId);

        if (isset($schedule['error'])) {
            return redirect()->route('home')->withErrors($schedule['errors']);
        }

        return view('client.league.schedule', compact('schedule'));
    }
}
