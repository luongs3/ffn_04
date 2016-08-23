<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateMatchRequest;
use App\Http\Requests\UpdateMatchRequest;
use App\Repositories\Match\MatchRepositoryInterface;
use App\Repositories\Team\TeamRepositoryInterface;
use App\Repositories\League\LeagueRepositoryInterface;
use App\Repositories\Season\SeasonRepositoryInterface;
use Carbon\Carbon;
use App\Repositories\MatchEvent\MatchEventRepositoryInterface;

class MatchController extends Controller
{
    private $matchRepository;
    private $teamRepository;
    private $leagueRepository;
    private $seasonRepository;
    private $matchEventRepository;

    public function __construct(
        MatchRepositoryInterface $matchRepository,
        TeamRepositoryInterface $teamRepository,
        LeagueRepositoryInterface $leagueRepository,
        SeasonRepositoryInterface $seasonRepository,
        MatchEventRepositoryInterface $matchEventRepository
    ) {
        $this->matchRepository = $matchRepository;
        $this->teamRepository = $teamRepository;
        $this->leagueRepository = $leagueRepository;
        $this->seasonRepository = $seasonRepository;
        $this->matchEventRepository = $matchEventRepository;
    }

    public function index()
    {
        $matches = $this->matchRepository->index('matches');

        return view('admin.layout.grid', $matches);
    }

    public function create()
    {
        $leagues = $this->leagueRepository->lists();

        if (isset($leagues['error'])) {
            return redirect()->route('admin.matches.index')->withError($leagues['error']);
        }

        $teams = $this->teamRepository->lists();

        return view('admin.match.create', compact('leagues', 'teams'));
    }

    public function store(CreateMatchRequest $request)
    {
        $match = $request->only(
            'league_id',
            'season_id',
            'team1_id',
            'team2_id',
            'place'
        );
        $match['start_time'] = Carbon::parse($request->get('start_time'))->toDateTimeString();
        $data = $this->matchRepository->store($match);

        if (isset($data['error'])) {
            return redirect()->route('admin.matches.create')->withError($data['error']);
        }

        return redirect()->route('admin.matches.index')->withSuccess(trans('message.create_match_successfully'));
    }

    public function edit($id)
    {
        $match = $this->matchRepository->show($id);

        if (isset($match['error'])) {
            return redirect()->route('admin.matches.index')->withError($match['error']);
        }

        $teams = $this->teamRepository->lists();

        if (isset($teams['error'])) {
            return redirect()->route('admin.matches.index')->withError($teams['error']);
        }

        $eventTypes = json_encode($this->matchEventRepository->getMatchEventTypes());
        $placeHolders = json_encode(config('common.place_holders'));

        return view('admin.match.edit', compact('match', 'teams', 'eventTypes', 'placeHolders'));
    }

    public function update(UpdateMatchRequest $request, $id)
    {
        $requestData = $request->only(
            'team1_id',
            'team2_id',
            'score_team1',
            'score_team2',
            'place'
        );
        $startTime = $request->get('start_time');
        $endTime = $request->get('end_time');
        $requestData['start_time'] = ($startTime != '0000-00-00 00:00:00' && !is_null($startTime))
            ? Carbon::parse($request->get('start_time'))->toDateTimeString() : '0000-00-00 00:00:00';
        $requestData['end_time'] = ($endTime != '0000-00-00 00:00:00' && !is_null($endTime))
            ? Carbon::parse($request->get('end_time'))->toDateTimeString() : '0000-00-00 00:00:00';
        $data = $this->matchRepository->update($requestData, $id);

        if (isset($data['error'])) {
            return redirect()->route('admin.matches.edit', ['id' => $id])->withError($data['error']);
        }

        return redirect()->route('admin.matches.index')->withSuccess(trans('message.update_match_successfully'));
    }

    public function destroy($ids)
    {
        if (request()->has('ids')) {
            $ids = request()->get('ids');
        }

        $data = $this->matchRepository->delete($ids);

        if (isset($data['error'])) {
            session()->flash('error', $data['error']['message']);

            return response()->json(['success' => false]);
        }

        session()->flash('success', trans('message.delete_successfully'));

        return response()->json(['success' => true]);
    }

    public function matchEvents($id)
    {
        $options = ['filter' => ['match_id' => $id]];
        $data = $this->matchEventRepository->all($options);

        return response()->json($data);
    }
}
