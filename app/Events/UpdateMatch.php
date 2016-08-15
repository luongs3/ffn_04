<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;

class UpdateMatch extends Event
{
    use SerializesModels;

    public $match;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($match)
    {
        $this->match = $match;
    }
}
