<?php

namespace Modules\Memberships\Database\Seeders;

use Modules\Email\Database\Seeders\Contracts\AbstractEmailTemplateSeeder;

class MembershipsEmailSeeder extends AbstractEmailTemplateSeeder
{
    protected string $moduleName = 'memberships';

    protected array $templates = [
        'subscription-created'        => \Modules\Memberships\Contracts\Emails\SubscriptionCreated::class,
        'subscription-paused'         => \Modules\Memberships\Contracts\Emails\SubscriptionPaused::class,
        'subscription-updated'        => \Modules\Memberships\Contracts\Emails\SubscriptionUpdated::class,
        'subscription-deleted'        => \Modules\Memberships\Contracts\Emails\SubscriptionDeleted::class,
        'subscription-trial-ended'    => \Modules\Memberships\Contracts\Emails\SubscriptionTrialEnded::class,
        'subscription-trial-upgraded' => \Modules\Memberships\Contracts\Emails\SubscriptionTrialUpgraded::class,
        'subscription-almost-ended'   => \Modules\Memberships\Contracts\Emails\SubscriptionAlmostEnded::class,
        'subscription-grace'          => \Modules\Memberships\Contracts\Emails\SubscriptionGrace::class,
        'subscription-ended'          => \Modules\Memberships\Contracts\Emails\SubscriptionEnded::class,
        'subscription-is-renewed'     => \Modules\Memberships\Contracts\Emails\SubscriptionIsRenewed::class,
    ];
}
