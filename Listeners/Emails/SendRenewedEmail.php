<?php

namespace Modules\Memberships\Listeners\Emails;

use Modules\Memberships\Events\SubscriptionIsRenewed;
use Modules\Email\Services\EmailService;

class SendRenewedEmail
{
    /**
     * Handle the event.
     *
     * @param  SubscriptionIsRenewed  $event
     * @return void
     */
    public function handle(SubscriptionIsRenewed $event)
    {

        $subscription = $event->subscription;


        $params = [
            "to" => $subscription->subscribable->email, // eller $event->subscription->user->email
            "template" => "subscription-is-renewed", // korrekt tag for fornyet abonnement
            "params" => [
                "subscription" => $subscription->toArray(),
                "user" => $subscription->subscribable->toArray(),
                "plan" => $subscription->plan->translate(),
            ],
        ];

        app(EmailService::class)->send($params);
    }
}
