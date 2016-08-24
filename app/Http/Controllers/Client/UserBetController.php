<?php
namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Repositories\UserBet\UserBetRepositoryInterface;

class UserBetController extends Controller
{
    private $userBetRepository;

    public function __construct(UserBetRepositoryInterface $userBetRepository)
    {
        $this->userBetRepository = $userBetRepository;
    }

    public function index()
    {
        $myBets = $this->userBetRepository->list();

        return view('userbet.list', compact('myBets'));
    }
}
