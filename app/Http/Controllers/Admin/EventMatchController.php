<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\MatchEvent\MatchEventRepositoryInterface;

class EventMatchController extends Controller
{
    private $matchEventRepository;

    public function __construct(MatchEventRepositoryInterface $matchEventRepository)
    {
        $this->matchEventRepository = $matchEventRepository;
    }

    public function index($id)
    {
        $options = ['filter' => ['match_id' => $id]];
        $data = $this->matchEventRepository->all($options);

        return response()->json($data);
    }
}
