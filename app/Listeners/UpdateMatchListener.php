<?php
namespace App\Listeners;

use App\Events\UpdateMatch;
use App\Models\Match;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Repositories\Rank\RankRepositoryInterface;
use App\Repositories\Match\MatchRepositoryInterface;

class UpdateMatchListener
{
    private $rankRepository;
    private $matchRepository;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(
        RankRepositoryInterface $rankRepository,
        MatchRepositoryInterface $matchRepository
    ) {
        $this->rankRepository = $rankRepository;
        $this->matchRepository = $matchRepository;
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

        if ($match['end_time'] != '0000-00-00 00:00:00') {
            $this->rankRepository->updateRankFromMatch($match);
        }
    }
}
