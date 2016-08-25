<?php
namespace App\Events;

use Illuminate\Queue\SerializesModels;

class CreateBet extends Event
{
    use SerializesModels;

    public $userBet;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($userBet)
    {
        $this->userBet = $userBet;
    }
}
