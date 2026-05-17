<?php

namespace Modules\Memberships\Listeners\Emails;

use Modules\Memberships\Events\SubscriptionCreated;
use Modules\Email\Services\EmailService;

class SendCreatedEmail
{
    /**
     * Handle the event.
     *
     * @param  SubscriptionCreated  $event
     * @return void
     */
    public function handle(SubscriptionCreated $event)
    {


        $subscription = $event->subscription;

        $params = [
            "to" => $subscription->subscribable->email, // eller $event->subscription->user->email
            "template" => "subscription-created", // korrekt tag for oprettet abonnement
            "params" => [
                "subscription" => $subscription->toArray(),
                "user" => $subscription->subscribable->toArray(),
                "plan" => $subscription->plan->translate(),
            ],
        ];

     

        $res = app(EmailService::class)->send($params);


    }
}
