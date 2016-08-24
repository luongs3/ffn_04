<?php
namespace App\Listeners;

use App\Events\UpdateMatch;
use App\Repositories\UserBet\UserBetRepositoryInterface;
use App\Repositories\Rank\RankRepositoryInterface;
use App\Repositories\Match\MatchRepositoryInterface;

class UpdateMatchListener
{
    private $rankRepository;
    private $matchRepository;
    private $userBetRepository;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(
        RankRepositoryInterface $rankRepository,
        MatchRepositoryInterface $matchRepository,
        UserBetRepositoryInterface $userBetRepository
    ) {
        $this->rankRepository = $rankRepository;
        $this->matchRepository = $matchRepository;
        $this->userBetRepository = $userBetRepository;
    }

    /**
     * Handle the event.
     *
     * @param  UpdateMatch  $event
     * @return void
     */
    public function handle(UpdateMatch $event)
    {
        $match = $event->match;
        $oldMatch = $this->matchRepository->show($match['id']);

        if (($match['end_time'] != '0000-00-00 00:00:00') && $oldMatch['end_time'] != $match['end_time']) {
            $this->rankRepository->updateRankFromMatch($match);
            $this->userBetRepository->calculateResult($match);
        }
    }
}
