<?php

namespace Modules\Memberships\Console\Commands;

use Illuminate\Console\Command;
use Modules\Memberships\Jobs\ProcessSubscriptionRenewals;

class CheckSubscriptionRenewals extends Command
{
    
    protected $signature = 'subscriptions:update-period';
    protected $description = 'Dispatch job to update subscription periods and handle expired trials';


    public function handle(): void
    {

        $this->info("Dispatching ProcessSubscriptionRenewals job...");

        ProcessSubscriptionRenewals::dispatch();

        $this->info("Job dispatched successfully.");

    }
}
