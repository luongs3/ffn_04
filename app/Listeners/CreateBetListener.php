<?php
namespace App\Listeners;

use App\Events\CreateBet;
use App\Repositories\AdminMessage\AdminMessageRepositoryInterface;

class CreateBetListener
{
    private $adminMessageRepository;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(
        AdminMessageRepositoryInterface $adminMessageRepository
    ) {
        $this->adminMessageRepository = $adminMessageRepository;
    }

    /**
     * Handle the event.
     *
     * @param  CreateBet  $event
     * @return void
     */
    public function handle(CreateBet $event)
    {
        $userBet = $event->userBet;
        $this->adminMessageRepository->alertCreateBet($userBet);
    }
}
