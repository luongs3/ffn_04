<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\CreateTeamRequest;
use App\Http\Requests\UpdateTeamRequest;
use App\Repositories\Team\TeamRepositoryInterface;
use App\Repositories\League\LeagueRepositoryInterface;
use App\Repositories\Player\PlayerRepositoryInterface;

class TeamController extends Controller
{
    private $teamRepository;
    private $leagueRepository;
    private $playerRepository;

    public function __construct(
        TeamRepositoryInterface $teamRepository,
        LeagueRepositoryInterface $leagueRepository,
        PlayerRepositoryInterface $playerRepository
    )
    {
        $this->teamRepository = $teamRepository;
        $this->leagueRepository = $leagueRepository;
        $this->playerRepository = $playerRepository;
    }

    public function index()
    {
        $teams = $this->teamRepository->index('teams');

        return view('layout.grid', $teams);
    }

    public function create()
    {
        $leagues = $this->leagueRepository->lists();
        $players = $this->playerRepository->index('players');

        return view('admin.team.create', compact('leagues'))->with($players) ;
    }

    public function store(CreateTeamRequest $request)
    {

        $team = $request->only(
            'name',
            'description',
            'league_id',
            'image_hidden',
            'players'
        );

        if ($request->hasFile('image')) {
            $team['image'] = $request->file('image');
        }

        $data = $this->teamRepository->store($team);

        if (isset($data['error'])) {
            return redirect()->route('admin.teams.create')->withError($data['error']);
        }

        return redirect()->route('admin.teams.index')->withSuccess(trans('message.create_team_successfully'));
    }

    public function edit($id)
    {
        $team = $this->teamRepository->show($id);

        if (isset($team['error'])) {
            return redirect()->route('admin.teams.index')->withError($team['error']);
        }

        $leagues = $this->leagueRepository->lists();
        $players = $this->playerRepository->index('players');

        return view('admin.team.edit', compact('team', 'leagues'))->with($players);
    }

    public function update(UpdateTeamRequest $request, $id)
    {
        $requestData = $request->only(
            'name',
            'description',
            'league_id',
            'image_hidden',
            'players'
        );

        if ($request->hasFile('image')) {
            $requestData['image'] = $request->file('image');
        }

        $data = $this->teamRepository->update($requestData, $id);

        if (isset($data['error'])) {
            return redirect()->route('admin.teams.edit', ['id' => $id])->withError($data['error']);
        }

        return redirect()->route('admin.teams.index')->withSuccess(trans('message.create_team_successfully'));
    }

    public function destroy($id)
    {
        if (request()->has('ids')) {
            $ids = request()->get('ids');
        }

        $data = $this->teamRepository->delete($ids);

        if (isset($data['errors'])) {
            session()->flash('error', $data['errors']['message']);

            return response()->json(['success' => false]);
        }

        session()->flash('success', trans('message.delete_successfully'));

        return response()->json(['success' => true]);
    }

    public function export()
    {
        $this->teamRepository->export('team');
    }
}
