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

    public function show($id)
    {

    }

    public function show($id)
    {

    }
}
