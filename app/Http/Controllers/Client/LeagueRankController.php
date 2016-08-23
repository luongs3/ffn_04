<?php
namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Repositories\League\LeagueRepositoryInterface;

class LeagueRankController extends Controller
{
    private $leagueRepository;

    public function __construct(LeagueRepositoryInterface $leagueRepository)
    {
        $this->leagueRepository = $leagueRepository;
    }

    public function index($leagueId)
    {
        $rank = $this->leagueRepository->rank($leagueId);

        if (isset($rank['error'])) {
            return redirect()->route('home')->withError($rank['error']);
        }

        return view('client.league.rank', compact('rank'));
    }
}
