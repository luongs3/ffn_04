<?php
namespace App\Http\Controllers\Client;

use App\Http\Requests\UserBetRequest;
use Auth;
use App\Http\Controllers\Controller;
use App\Repositories\UserBet\UserBetRepositoryInterface;
use App\Repositories\Match\MatchRepositoryInterface;
use App\Repositories\Team\TeamRepositoryInterface;
use App\Repositories\League\LeagueRepositoryInterface;

class MatchBetController extends Controller
{
    private $userBetRepository;
    private $matchRepository;
    private $teamRepository;
    private $leagueRepository;

    public function __construct(
        UserBetRepositoryInterface $userBetRepository,
        MatchRepositoryInterface $matchRepository,
        TeamRepositoryInterface $teamRepository,
        LeagueRepositoryInterface $leagueRepository
    ) {
        $this->userBetRepository = $userBetRepository;
        $this->matchRepository = $matchRepository;
        $this->teamRepository = $teamRepository;
        $this->leagueRepository = $leagueRepository;
    }

    public function create($matchId)
    {
        $match = $this->matchRepository->show($matchId);

        return view('userbet.create', compact('match'));
    }

    public function store(UserBetRequest $request, $id)
    {
        if ((int)$request->point <= Auth::user()->point) {
            $userBet = $this->userBetRepository->bet($request, $id);

            return redirect()->action('Client\UserBetController@index', ['id' => Auth::user()->id])->with(['message' => trans('message.bet_successfully')]);
        }

        return redirect()->action('Client\UserBetController@index', ['id' => Auth::user()->id])->withErrors(trans('message.create_bet_fail'));
    }

    public function edit($matchId, $id)
    {
        $userBet = $this->userBetRepository->show($id);
        $match = $this->matchRepository->show($matchId);

        return view('userbet.edit', compact('userBet', 'match'));
    }

    public function update(UserBetRequest $request, $matchId, $id)
    {
        $match = $this->matchRepository->show($matchId);

        if ((int)$request->point > Auth::user()->point) {
            return redirect()->action('Client\UserBetController@index', ['id' => Auth::user()->id])->withErrors(trans('message.edit_bet_fail'));
        }

        $userBet = $this->userBetRepository->updateBets($request, $id);

        return redirect()->action('Client\UserBetController@index', ['id' => Auth::user()->id])->with(['message' => trans('message.update_bet_success')]);
    }

    public function destroy($matchId, $id)
    {
        try {
            $match = $this->matchRepository->show($matchId);
            $userBetID = $this->userBetRepository->show($id);
            $userBetID->delete();

            return redirect()->action('Client\UserBetController@index')
                ->with(['message' => trans('message.delete_success')]);
        } catch(Exception $e) {
            return redirect()->action('Client\UserBetController@index')
                ->withErrors(trans('message.delete_fail'));
        }
    }
}
