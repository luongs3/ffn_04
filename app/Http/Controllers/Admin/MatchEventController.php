<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateMatchEventRequest;
use App\Http\Requests\UpdateMatchEventRequest;
use App\Repositories\League\LeagueRepositoryInterface;
use App\Repositories\MatchEvent\MatchEventRepositoryInterface;
use App\Repositories\Match\MatchRepositoryInterface;

class MatchEventController extends Controller
{
    private $matchEventRepository;
    private $matchRepository;
    private $leagueRepository;

    public function __construct(
        MatchEventRepositoryInterface $matchEventRepository,
        MatchRepositoryInterface $matchRepository,
        LeagueRepositoryInterface $leagueRepository
    ) {
        $this->matchEventRepository = $matchEventRepository;
        $this->matchRepository = $matchRepository;
        $this->leagueRepository = $leagueRepository;
    }

    public function index()
    {
        $matchEvents = $this->matchEventRepository->index('match-events');

        return view('layout.grid', $matchEvents);
    }

    public function create()
    {
        $leagues = $this->leagueRepository->lists();

        if (isset($leagues['errors'])) {
            return redirect()->route('admin.match-events.index')->withErrors($leagues['errors']);
        }

        $iconTypes = $this->matchEventRepository->getIconTypes();

        return view('admin.match_event.create', compact('iconTypes', 'leagues'));
    }

    public function store(CreateMatchEventRequest $request)
    {
        $matchEvent = $request->only(
            'match_id',
            'time',
            'icon',
            'image_hidden',
            'image',
            'title',
            'content'
        );
        $data = $this->matchEventRepository->store($matchEvent);

        if (isset($data['error'])) {
            return redirect()->route('admin.match-events.create')->withError($data['error']);
        }

        if (request()->ajax()) {
            $options = ['filter' => ['match_id' => $request->get('match_id')]];
            $data = $this->matchEventRepository->all($options);

            return response()->json($data);
        }

        return redirect()->route('admin.match-events.index')->withSuccess(trans('message.create_match_event_successfully'));
    }

    public function edit($id)
    {
        $matchEvent = $this->matchEventRepository->show($id);

        if (isset($matchEvent['error'])) {
            return redirect()->route('admin.match-events.index')->withError($matchEvent['error']);
        }

        $matches = $this->matchRepository->getMatchName();
        $iconTypes = $this->matchEventRepository->getIconTypes();

        if (isset($matches['errors'])) {
            return redirect()->route('admin.match-events.index')->withErrors($matches['errors']);
        }

        return view('admin.match_event.edit', compact('matchEvent', 'matches', 'iconTypes'));
    }

    public function update(UpdateMatchEventRequest $request, $id)
    {
        $requestData = $request->only(
            'match_id',
            'time',
            'icon',
            'image',
            'title',
            'content'
        );
        $data = $this->matchEventRepository->update($requestData, $id);

        if (isset($data['error'])) {
            return redirect()->route('admin.match-events.edit', ['id' => $id])->withError($data['error']);
        }

        return redirect()->route('admin.match-events.index')->withSuccess(trans('message.create_match_event_successfully'));
    }

    public function destroy($ids)
    {
        if (request()->has('ids')) {
            $ids = request()->get('ids');
        }

        $data = $this->matchEventRepository->delete($ids);

        if (isset($data['errors'])) {
            session()->flash('error', $data['errors']['message']);

            return response()->json(['success' => false]);
        }

        session()->flash('success', trans('message.delete_successfully'));

        return response()->json(['success' => true]);
    }

    public function export()
    {
        $this->matchEventRepository->export('matchEvent');
    }

    public function getMatchNames()
    {
        $filter = request()->only('season_id');
        $data = $this->matchRepository->getMatchName(null, $filter);

        if (isset($data['errors'])) {
            return response()->json(['error' => $data['errors']]);
        }

        foreach ($data as $key => $value) {
            $newData[] = [
                'id' => $key,
                'name' => $value,
            ];
        }

        return response()->json($newData);
    }
}
