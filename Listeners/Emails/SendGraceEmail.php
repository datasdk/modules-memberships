<?php

namespace Modules\Memberships\Listeners\Emails;

use Modules\Memberships\Events\SubscriptionGrace;
use Modules\Email\Services\EmailService;
use Illuminate\Support\Facades\Log;

class SendGraceEmail
{
    /**
     * Handle the event.
     *
     * @param  SubscriptionGrace  $event
     * @return void
     */
    public function handle(SubscriptionGrace $event)
    {

        $subscription = $event->subscription;


        // Tjek om email allerede er sendt
        if ($subscription->hasSentEmail("subscription-grace")) {

            Log::notice("Subscription #{$subscription->id} has already received 'subscription-grace' email.");

            return false;

        }


        $params = [
            "to" => $subscription->subscribable->email, // eller $subscription->user->email
            "template" => "subscription-grace",
            "params" => [
                "subscription" => $subscription->toArray(),
                "user" => $subscription->subscribable->toArray(),
                "plan" => $subscription->plan->translate(),
                "grace_days" => $subscription->plan->grace_days ?? 7, // fx default 7 dage
                "url" => route("memberships.renew", $subscription->id)
            ],
            "model" => $subscription
        ];

        app(EmailService::class)->send($params);
    }
}
