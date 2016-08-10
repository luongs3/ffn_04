<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Repositories\Match\MatchRepositoryInterface;

class MatchController extends Controller
{
    private $matchRepository;

    public function __construct(MatchRepositoryInterface $matchRepository)
    {
        $this->matchRepository = $matchRepository;
    }

    public function show($id)
    {
        $match = $this->matchRepository->show($id);
        $match = $this->matchRepository->getMatchName($match);

        if (isset($match['error'])) {
            return redirect()->route('/')->withError($match['error']);
        }

        return view('client.match.show', compact('match'));
    }
}
