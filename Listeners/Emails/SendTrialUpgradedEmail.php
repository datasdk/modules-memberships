<?php

namespace Modules\Memberships\Listeners\Emails;

use Modules\Memberships\Events\SubscriptionTrialUpgraded;
use Modules\Email\Services\EmailService;
use Illuminate\Support\Facades\Log;

class SendTrialUpgradedEmail
{
    /**
     * Handle the event.
     *
     * @param SubscriptionTrialUpgraded $event
     * @return void
     */
    public function handle(SubscriptionTrialUpgraded $event)
    {

        
        $subscription = $event->subscription;


        // Tjek om email allerede er sendt
        if ($subscription->hasSentEmail("subscription-trial-upgraded")) {
            Log::notice("Subscription #{$subscription->id} has already received 'subscription-trial-upgraded' email.");
            return false;
        }


        $params = [
            "to" => $subscription->subscribable->email, // eller $subscription->user->email
            "template" => "subscription-trial-upgraded",
            "params" => [
                "subscription" => $subscription->toArray(),
                "user" => $subscription->subscribable->toArray(),
                "plan" => $subscription->plan->translate(),
            ],
            "model" => $subscription, // binder email til modellen
        ];


        app(EmailService::class)->send($params);


    }


}
