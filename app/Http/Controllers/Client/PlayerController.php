<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Repositories\Player\PlayerRepositoryInterface;

class PlayerController extends Controller
{
    private $playerRepository;

    public function __construct(PlayerRepositoryInterface $playerRepository)
    {
        $this->playerRepository = $playerRepository;
    }

    public function show($id)
    {
        $player = $this->playerRepository->show($id);

        if (isset($player['error'])) {
            return redirect()->route('home')->withError($player['error']);
        }

        return view('client.player.show', compact('player'));
    }
}
