<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\CreatePlayerRequest;
use App\Http\Requests\UpdatePlayerRequest;
use App\Repositories\Player\PlayerRepositoryInterface;
use App\Repositories\Team\TeamRepositoryInterface;

class PlayerController extends Controller
{
    private $playerRepository;
    private $teamRepository;

    public function __construct(PlayerRepositoryInterface $playerRepository, TeamRepositoryInterface $teamRepository)
    {
        $this->playerRepository = $playerRepository;
        $this->teamRepository = $teamRepository;
    }

    public function index()
    {
        $players = $this->playerRepository->index('players');

        return view('layout.grid', $players);
    }

    public function create()
    {
        $teams = $this->teamRepository->lists();
        $roleValues = $this->playerRepository->getPlayerRoles();

        return view('admin.player.create', compact('teams', 'roleValues'));
    }

    public function store(CreatePlayerRequest $request)
    {
        $player = $request->only(
            'name',
            'role',
            'team_id',
            'image_hidden'
        );

        if ($request->hasFile('image')) {
            $player['image'] = $request->file('image');
        }

        $data = $this->playerRepository->store($player);

        if (isset($data['error'])) {
            return redirect()->route('admin.players.create')->withError($data['error']);
        }

        return redirect()->route('admin.players.index')->withSuccess(trans('message.create_player_successfully'));
    }

    public function edit($id)
    {
        $player = $this->playerRepository->show($id);

        if (isset($player['error'])) {
            return redirect()->route('admin.players.index')->withError($player['error']);
        }

        $teams = $this->teamRepository->lists();
        $roleValues = $this->playerRepository->getPlayerRoles();

        return view('admin.player.edit', compact('player', 'teams', 'roleValues'));
    }

    public function update(UpdatePlayerRequest $request, $id)
    {
        $requestData = $request->only(
            'name',
            'role',
            'team_id',
            'image_hidden'
        );

        if ($request->hasFile('image')) {
            $requestData['image'] = $request->file('image');
        }

        $data = $this->playerRepository->update($requestData, $id);

        if (isset($data['error'])) {
            return redirect()->route('admin.players.edit', ['id' => $id])->withError($data['error']);
        }

        return redirect()->route('admin.players.index')->withSuccess(trans('message.create_player_successfully'));
    }

    public function destroy($id)
    {
        if (request()->has('ids')) {
            $ids = request()->get('ids');
        }

        $data = $this->playerRepository->delete($ids);

        if (isset($data['errors'])) {
            session()->flash('error', $data['errors']['message']);

            return response()->json(['success' => false]);
        }

        session()->flash('success', trans('message.delete_successfully'));

        return response()->json(['success' => true]);
    }

    public function export()
    {
        $this->playerRepository->export('player');
    }
}
