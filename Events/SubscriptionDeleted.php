<?php

namespace Modules\Memberships\Events;

use Modules\Memberships\Models\Subscription;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SubscriptionDeleted
{
    
    use Dispatchable, SerializesModels;

    public Subscription $subscription;


    public function __construct(Subscription $subscription)
    {
        $this->subscription = $subscription;
    }
}
