<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateSeasonRequest;
use App\Http\Requests\UpdateSeasonRequest;
use App\Repositories\League\LeagueRepositoryInterface;
use App\Repositories\Season\SeasonRepositoryInterface;
use App\Repositories\Team\TeamRepositoryInterface;

class SeasonController extends Controller
{
    private $seasonRepository;
    private $leagueRepository;

    public function __construct(
        SeasonRepositoryInterface $seasonRepository,
        LeagueRepositoryInterface $leagueRepository
    ) {
        $this->seasonRepository = $seasonRepository;
        $this->leagueRepository = $leagueRepository;
    }

    public function index()
    {
        $seasons = $this->seasonRepository->index('seasons');

        return view('admin.layout.grid', $seasons);
    }

    public function create()
    {
        $leagues = $this->leagueRepository->lists();

        return view('admin.season.create', compact('leagues'));
    }

    public function store(CreateSeasonRequest $request)
    {
        $season = $request->only(
            'name',
            'league_id'
        );
        $data = $this->seasonRepository->store($season);

        if (isset($data['error'])) {
            return redirect()->route('admin.seasons.create')->withError($data['error']);
        }

        return redirect()->route('admin.seasons.index')->withSuccess(trans('message.create_season_successfully'));
    }

    public function edit($id)
    {
        $season = $this->seasonRepository->show($id);
        $season['league_id'] = $season->leagues()->first()->id;

        if (isset($season['error'])) {
            return redirect()->route('admin.seasons.index')->withError($season['error']);
        }

        $leagues = $this->leagueRepository->lists();

        return view('admin.season.edit', compact('season', 'leagues'));
    }

    public function update(UpdateSeasonRequest $request, $id)
    {
        $requestData = $request->only(
            'name',
            'league_id'
        );
        $data = $this->seasonRepository->update($requestData, $id);

        if (isset($data['error'])) {
            return redirect()->route('admin.seasons.edit', ['id' => $id])->withError($data['error']);
        }

        return redirect()->route('admin.seasons.index')->withSuccess(trans('message.update_season_successfully'));
    }

    public function destroy($ids)
    {
        if (request()->has('ids')) {
            $ids = request()->get('ids');
        }

        $data = $this->seasonRepository->delete($ids);

        if (isset($data['errors'])) {
            session()->flash('error', $data['errors']['message']);

            return response()->json(['success' => false]);
        }

        session()->flash('success', trans('message.delete_successfully'));

        return response()->json(['success' => true]);
    }

    public function ajaxSeasons()
    {
        $filter = request()->only('league_id');
        $data = $this->seasonRepository->filter($filter);

        if (isset($data['errors'])) {
            return response()->json(['error' => $data['errors']]);
        }

        return response()->json($data);
    }
}
