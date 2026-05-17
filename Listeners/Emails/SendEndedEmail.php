<?php

namespace Modules\Memberships\Listeners\Emails;

use Modules\Memberships\Events\SubscriptionEnded;
use Modules\Email\Services\EmailService;
use Illuminate\Support\Facades\Log;

class SendEndedEmail
{
    /**
     * Handle the event.
     *
     * @param  SubscriptionEnded  $event
     * @return void|bool
     */
    public function handle(SubscriptionEnded $event)
    {

        $subscription = $event->subscription;

        $emailTemplate = "subscription-ended";


        // Tjek om email allerede er sendt
        if ($subscription->hasSentEmail($emailTemplate)) {

            Log::notice("⚠️ Subscription #{$subscription->id} har allerede modtaget '{$emailTemplate}' email.");

            return false;

        }


        $params = [
            "to" => $subscription->subscribable->email,
            "template" => $emailTemplate,
            "params" => [
                "subscription" => $subscription->toArray(),
                "user" => $subscription->subscribable->toArray(),
                "plan" => $subscription->plan->translate(),
            ],
            "model" => $subscription,
        ];


        // Send email
        app(EmailService::class)->send($params);

       
    }
}
