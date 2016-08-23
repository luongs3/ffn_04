<?php
namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Repositories\League\LeagueRepositoryInterface;

class LeagueScheduleController extends Controller
{
    private $leagueRepository;

    public function __construct(LeagueRepositoryInterface $leagueRepository)
    {
        $this->leagueRepository = $leagueRepository;
    }

    public function index($leagueId)
    {
        $schedule = $this->leagueRepository->schedule($leagueId);

        if (isset($schedule['error'])) {
            return redirect()->route('home')->withError($schedule['error']);
        }

        return view('client.league.schedule', compact('schedule'));
    }
}
