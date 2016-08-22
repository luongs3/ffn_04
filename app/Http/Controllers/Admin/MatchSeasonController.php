<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Match\MatchRepositoryInterface;

class MatchSeasonController extends Controller
{
    private $matchRepository;

    public function __construct(MatchRepositoryInterface $matchRepository) {
        $this->matchRepository = $matchRepository;
    }

    public function index($seasonId)
    {
        $filter = ['season_id' => $seasonId];
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
