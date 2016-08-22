<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Team\TeamRepositoryInterface;

class AjaxTeamController extends Controller
{
    private $teamRepository;

    public function __construct(TeamRepositoryInterface $teamRepository)
    {
        $this->teamRepository = $teamRepository;
    }

    public function index()
    {
        $filter = request()->only('league_id');
        $data = $this->teamRepository->filter($filter);

        if (isset($data['error'])) {
            return response()->json(['error' => $data['error']]);
        }

        return response()->json($data);
    }
}
