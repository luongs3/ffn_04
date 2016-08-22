<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Season\SeasonRepositoryInterface;

class AjaxSeasonController extends Controller
{
    private $seasonRepository;

    public function __construct(SeasonRepositoryInterface $seasonRepository) {
        $this->seasonRepository = $seasonRepository;
    }

    public function index()
    {
        $filter = request()->only('league_id');
        $data = $this->seasonRepository->filter($filter);

        if (isset($data['error'])) {
            return response()->json(['error' => $data['error']]);
        }

        return response()->json($data);
    }
}
