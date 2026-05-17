<?php

namespace Modules\Memberships\Listeners\Emails;

use Modules\Memberships\Events\SubscriptionAlmostEnded;
use Modules\Email\Services\EmailService;
use Illuminate\Support\Facades\Log;

class SendAlmostEndedEmail
{
    /**
     * Handle the event.
     *
     * @param SubscriptionAlmostEnded $event
     * @return void|bool
     */
    public function handle(SubscriptionAlmostEnded $event)
    {

        $subscription = $event->subscription;

        $emailTemplate = "subscription-almost-ended";


        // Tjek om email allerede er sendt i dag
        if ($subscription->hasSentEmail($emailTemplate)) {

            Log::notice("⏳ Subscription #{$subscription->id} har allerede modtaget '{$emailTemplate}' email i dag.");

            return false;

        }

        /*
        // Maks 3 mails
        if ($subscription->sentEmailCount($emailTemplate) >= 3) {

            Log::notice("🚫 Subscription #{$subscription->id} har allerede modtaget '{$emailTemplate}' email 3 gange. Springes over.");

            return false;

        }
            */

        $url = route("memberships.renew", $subscription->id);


        $params = [
            "to" => $subscription->subscribable->email,
            "template" => $emailTemplate,
            "params" => [
                "url" => $url,
            ],
            "model" => $subscription,
        ];


        // Send email
        app(EmailService::class)->send($params);


        // Log succes
        Log::notice("✅ 'subscription-almost-ended' email sendt til {$subscription->subscribable->email} for subscription #{$subscription->id}.");



    }

}
