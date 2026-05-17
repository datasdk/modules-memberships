<?php

namespace Modules\Memberships\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SubscriptionCreate
{
    use Dispatchable, SerializesModels;

    /**
     * Data til at oprette et abonnement
     */
    public array $params;

    /**
     * Opret nyt event
     */
    public function __construct(array $params)
    {
        $this->params = $params;
    }
}
