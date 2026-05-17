<?php

namespace Modules\Memberships\Observers;

use Modules\Memberships\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class SubscriptionObserver
{
    /**
     * Handle the Subscription "creating" event.
     */
    public function creating(Subscription $subscription): void
    {
     
    }

    /**
     * Handle the Subscription "deleted" event.
     */
    public function deleted(Subscription $subscription): void
    {
        
    

    }

    /**
     * Handle the Subscription "updating" event.
     * Eksempel: du kan reset usage ved plan change her
     */
    public function updating(Subscription $subscription): void
    {

    
    }
    
}
