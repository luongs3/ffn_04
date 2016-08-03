<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateLeagueRequest;
use App\Http\Requests\UpdateLeagueRequest;
use App\Repositories\League\LeagueRepositoryInterface;
use App\Repositories\Team\TeamRepositoryInterface;

class LeagueController extends Controller
{
    private $leagueRepository;
    private $teamRepository;

    public function __construct(LeagueRepositoryInterface $leagueRepository, TeamRepositoryInterface $teamRepository)
    {
        $this->leagueRepository = $leagueRepository;
        $this->teamRepository = $teamRepository;
    }

    public function index()
    {
        $leagues = $this->leagueRepository->index('leagues');

        return view('layout.grid', $leagues);
    }

    public function create()
    {
        return view('admin.league.create');
    }

    public function store(CreateLeagueRequest $request)
    {
        $league = $request->only(
            'name',
            'description',
            'image_hidden'
        );

        if ($request->hasFile('image')) {
            $league['image'] = $request->file('image');
        }

        $data = $this->leagueRepository->store($league);

        if (isset($data['error'])) {
            return redirect()->route('admin.leagues.create')->withError($data['error']);
        }

        return redirect()->route('admin.leagues.index')->withSuccess(trans('message.create_league_successfully'));
    }

    public function edit($id)
    {
        $league = $this->leagueRepository->show($id);

        if (isset($league['error'])) {
            return redirect()->route('admin.leagues.index')->withError($league['error']);
        }

        return view('admin.league.edit', compact('league'));
    }

    public function update(UpdateLeagueRequest $request, $id)
    {
        $requestData = $request->only(
            'name',
            'description',
            'image_hidden'
        );

        if ($request->hasFile('image')) {
            $requestData['image'] = $request->file('image');
        }

        $data = $this->leagueRepository->update($requestData, $id);

        if (isset($data['error'])) {
            return redirect()->route('admin.leagues.edit', ['id' => $id])->withError($data['error']);
        }

        return redirect()->route('admin.leagues.index')->withSuccess(trans('message.create_league_successfully'));
    }

    public function destroy($id)
    {
        if (request()->has('ids')) {
            $ids = request()->get('ids');
        }

        $data = $this->leagueRepository->delete($ids);

        if (isset($data['errors'])) {
            session()->flash('error', $data['errors']['message']);

            return response()->json(['success' => false]);
        }

        session()->flash('success', trans('message.delete_successfully'));

        return response()->json(['success' => true]);
    }

    public function export()
    {
        $this->leagueRepository->export('league');
    }
}
