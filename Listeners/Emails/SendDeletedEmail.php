<?php

namespace Modules\Memberships\Listeners\Emails;

use Modules\Memberships\Events\SubscriptionDeleted;
use Modules\Email\Services\EmailService;

class SendDeletedEmail
{
    /**
     * Handle the event.
     *
     * @param  SubscriptionDeleted  $event
     * @return void
     */
    public function handle(SubscriptionDeleted $event)
    {

        $subscription = $event->subscription;

        $params = [
            "to" => $subscription->subscribable->email, // eller $event->subscription->user->email
            "template" => "subscription-deleted", // korrekt tag for slettet abonnement
            "params" => [
                "subscription" => $subscription->toArray(),
                "user" => $subscription->subscribable->toArray(),
                "plan" => $subscription->plan->translate(),
            ],
        ];

        app(EmailService::class)->send($params);
    }
}
