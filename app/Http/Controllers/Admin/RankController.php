<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateRankRequest;
use App\Http\Requests\UpdateRankRequest;
use App\Repositories\Rank\RankRepositoryInterface;
use App\Repositories\Team\TeamRepositoryInterface;
use App\Repositories\Season\SeasonRepositoryInterface;

class RankController extends Controller
{
    private $rankRepository;
    private $teamRepository;
    private $seasonRepository;

    public function __construct(
        RankRepositoryInterface $rankRepository,
        TeamRepositoryInterface $teamRepository,
        SeasonRepositoryInterface $seasonRepository
    )
    {
        $this->rankRepository = $rankRepository;
        $this->teamRepository = $teamRepository;
        $this->seasonRepository = $seasonRepository;
    }

    public function index()
    {
        $ranks = $this->rankRepository->index('ranks');

        return view('admin.layout.grid', $ranks);
    }

    public function create()
    {
        $seasons = $this->seasonRepository->lists();

        if (isset($seasons['error'])) {
            return redirect()->route('admin.ranks.index')->withErrors($seasons['error']);
        }

        return view('admin.rank.create', compact('seasons'));
    }

    public function store(CreateRankRequest $request)
    {
        $rank = $request->only(
            'season_id'
        );

        $data = $this->rankRepository->store($rank);

        if (isset($data['error'])) {
            return redirect()->route('admin.ranks.create')->withError($data['error']);
        }

        return redirect()->route('admin.ranks.index')->withSuccess(trans('message.create_rank_successfully'));
    }

    public function edit($id)
    {
        $rank = $this->rankRepository->show($id);

        if (isset($rank['error'])) {
            return redirect()->route('admin.ranks.index')->withError($rank['error']);
        }

        $teams = $this->teamRepository->lists();
        $seasons = $this->seasonRepository->lists();

        if (isset($seasons['error'])) {
            return redirect()->route('admin.ranks.index')->withErrors($seasons['error']);
        }

        return view('admin.rank.edit', compact('rank', 'seasons', 'teams'));
    }

    public function update(UpdateRankRequest $request, $id)
    {
        $requestData = $request->only(
            'season_id',
            'team_id',
            'score',
            'number'
        );
        $data = $this->rankRepository->update($requestData, $id);

        if (isset($data['error'])) {
            return redirect()->route('admin.ranks.edit', ['id' => $id])->withError($data['error']);
        }

        return redirect()->route('admin.ranks.index')->withSuccess(trans('message.update_rank_successfully'));
    }

    public function destroy($ids)
    {
        if (request()->has('ids')) {
            $ids = request()->get('ids');
        }

        $data = $this->rankRepository->delete($ids);

        if (isset($data['errors'])) {
            session()->flash('error', $data['errors']['message']);

            return response()->json(['success' => false]);
        }

        session()->flash('success', trans('message.delete_successfully'));

        return response()->json(['success' => true]);
    }

    public function export()
    {
        $this->rankRepository->export('rank');
    }
}
