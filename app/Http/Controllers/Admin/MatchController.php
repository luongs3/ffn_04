<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateMatchRequest;
use App\Http\Requests\UpdateMatchRequest;
use App\Repositories\Match\MatchRepositoryInterface;
use App\Repositories\Team\TeamRepositoryInterface;
use Carbon\Carbon;

class MatchController extends Controller
{
    private $matchRepository;
    private $teamRepository;

    public function __construct(MatchRepositoryInterface $matchRepository, TeamRepositoryInterface $teamRepository)
    {
        $this->matchRepository = $matchRepository;
        $this->teamRepository = $teamRepository;
    }

    public function index()
    {
        $matches = $this->matchRepository->index('matches');

        return view('layout.grid', $matches);
    }

    public function create()
    {
        $teams = $this->teamRepository->lists();

        if (isset($teams['errors'])) {
            return redirect()->route('admin.matches.index')->withErrors($teams['errors']);
        }

        return view('admin.match.create', compact('teams'));
    }

    public function store(CreateMatchRequest $request)
    {
        $match = $request->only(
            'team1_id',
            'team2_id',
            'place'
        );
        $match['start_time'] = Carbon::parse($request->get('start_time'))->toDateTimeString();
        $match['end_time'] = Carbon::parse($request->get('end_time'))->toDateTimeString();
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

        return view('admin.match.edit', compact('match', 'teams'));
    }

    public function update(UpdateMatchRequest $request, $id)
    {
        $requestData = $request->only(
            'team1_id',
            'team2_id',
            'score_team1',
            'score_team2',
            'place',
            'start_time',
            'end_time'
        );

        $data = $this->matchRepository->update($requestData, $id);

        if (isset($data['error'])) {
            return redirect()->route('admin.matches.edit', ['id' => $id])->withError($data['error']);
        }

        return redirect()->route('admin.matches.index')->withSuccess(trans('message.create_match_successfully'));
    }

    public function destroy($id)
    {
        if (request()->has('ids')) {
            $ids = request()->get('ids');
        }

        $data = $this->matchRepository->delete($ids);

        if (isset($data['errors'])) {
            session()->flash('error', $data['errors']['message']);

            return response()->json(['success' => false]);
        }

        session()->flash('success', trans('message.delete_successfully'));

        return response()->json(['success' => true]);
    }

    public function export()
    {
        $this->matchRepository->export('match');
    }
}
