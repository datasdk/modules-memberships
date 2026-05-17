<?php

namespace Modules\Memberships\Listeners\Emails;

use Modules\Memberships\Events\SubscriptionUpdated;
use Modules\Email\Services\EmailService;

class SendUpdatedEmail
{
    /**
     * Handle the event.
     *
     * @param  SubscriptionUpdated  $event
     * @return void
     */
    public function handle(SubscriptionUpdated $event)
    {

        $subscription = $event->subscription;


        $params = [
            "to" => $subscription->subscribable->email, // eller $event->subscription->user->email
            "template" => "subscription-updated", // korrekt tag for opdateret abonnement
            "params" => [
                "subscription" => $event->subscription->toArray(),
                "user" => $subscription->subscribable->toArray(),
                "plan" => $subscription->plan->translate(),
            ],
        ];

        app(EmailService::class)->send($params);
    }
}
