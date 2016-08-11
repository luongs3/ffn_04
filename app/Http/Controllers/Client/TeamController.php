<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Repositories\Team\TeamRepositoryInterface;

class TeamController extends Controller
{
    private $teamRepository;

    public function __construct(TeamRepositoryInterface $teamRepository)
    {
        $this->teamRepository = $teamRepository;
    }

    public function show($id)
    {
        $team = $this->teamRepository->show($id);

        if (isset($team['error'])) {
            return redirect()->route('home')->withError($team['error']);
        }

        $players = $team->players;

        return view('client.team.show', compact('team', 'players'));
    }
}
