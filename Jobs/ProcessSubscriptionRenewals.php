<?php

namespace Modules\Memberships\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\Memberships\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

// Events
use Modules\Memberships\Events\SubscriptionIsRenewed;
use Modules\Memberships\Events\SubscriptionTrialEnded;
use Modules\Memberships\Events\SubscriptionTrialUpgraded;
use Modules\Memberships\Events\SubscriptionAlmostEnded;
use Modules\Memberships\Events\SubscriptionEnded;

class ProcessSubscriptionRenewals implements ShouldQueue
{

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public function handle(): void
    {

        $now = Carbon::now()->endOfDay();


        $this->processExpiredTrials($now);

        $this->processAlmostEnded($now);

        $this->processAutoRenew($now);

        $this->processEnded($now);

    }


    private function processExpiredTrials(Carbon $now): void
    {


        $subscriptions = Subscription::with('plan')
            ->whereNotNull('trial_ends_at')
            ->where('trial_ends_at', '<=', $now)
            ->where('ends_at', '>', $now)
            ->where('trial_ends_at', '>=', Carbon::now()->subDays(7))
            ->where('permanent_membership', 0)
            ->get();



        foreach ($subscriptions as $subscription) {

            

            if ($subscription->canceled()) {

           
                continue;

            }


            if ($subscription->trial_auto_upgrade) {

                event(new SubscriptionTrialUpgraded($subscription));

             

            } else {

                $subscription->cancel();

             
                event(new SubscriptionTrialEnded($subscription));

            }

        }


    }


    private function processAlmostEnded(Carbon $now): void
    {

        $subscriptions = Subscription::with('plan')
            ->where('memberships_subscriptions.auto_renew', 0)
            ->whereNotNull('ends_at')
            ->where('ends_at', '>=', $now)
            ->where('ends_at', '<=', $now->copy()->addDays(3))
            ->where('permanent_membership', 0)
            ->get();
            

        foreach ($subscriptions as $subscription) {

            event(new SubscriptionAlmostEnded($subscription));

        }

    }


    private function processAutoRenew(Carbon $now): void
    {


        $subscriptions = Subscription::with('plan')
            ->where('memberships_subscriptions.auto_renew', 1)
            ->where('memberships_subscriptions.ends_at', '<=', $now)
            ->where('permanent_membership', 0)
            ->get();



        foreach ($subscriptions as $subscription) {

            $subscription->renew();

      
            event(new SubscriptionIsRenewed($subscription));

        }


    }


    private function processEnded(Carbon $now): void
    {

        $subscriptions = Subscription::with('plan')
            ->where('ends_at', '<=', $now)
            ->where('auto_renew', false)
            ->where('permanent_membership', 0)
            ->get();


        foreach ($subscriptions as $subscription) {

            event(new SubscriptionEnded($subscription));

        }

    }

}
