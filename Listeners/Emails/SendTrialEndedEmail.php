<?php

namespace Modules\Memberships\Listeners\Emails;

use Modules\Memberships\Events\SubscriptionTrialEnded;
use Modules\Email\Services\EmailService;

class SendTrialEndedEmail
{
    /**
     * Handle the event.
     *
     * @param  SubscriptionTrialEnded  $event
     * @return void
     */
    public function handle(SubscriptionTrialEnded $event)
    {

        $subscription = $event->subscription;


        $params = [
            "to" => $subscription->subscribable->email, // eller $event->subscription->user->email
            "template" => "subscription-trial-ended", // korrekt tag for afsluttet trial
            "params" => [
                "subscription" => $subscription->toArray(),
                "user" => $subscription->subscribable->toArray(),
                "plan" => $subscription->plan->translate(),
            ],
        ];

        app(EmailService::class)->send($params);
    }
}
