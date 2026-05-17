<?php

namespace Modules\Memberships\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [

        \Modules\Shop\Events\ShopOrderProductCreate::class => [
            \Modules\Memberships\Listeners\HandleCreateSubscription::class
        ],
        
        // When a subscription is created
        \Modules\Memberships\Events\SubscriptionCreated::class => [
            \Modules\Memberships\Listeners\Emails\SendCreatedEmail::class,
        ],

        // When a subscription is updated
        \Modules\Memberships\Events\SubscriptionUpdated::class => [
            \Modules\Memberships\Listeners\Emails\SendUpdatedEmail::class,
        ],

        // When a subscription is deleted
        \Modules\Memberships\Events\SubscriptionDeleted::class => [
            \Modules\Memberships\Listeners\Emails\SendDeletedEmail::class,
        ],

        // When a subscription trial ends
        \Modules\Memberships\Events\SubscriptionTrialEnded::class => [
            \Modules\Memberships\Listeners\Emails\SendTrialEndedEmail::class,
        ],

        // When a subscription trial is upgraded automatically
        \Modules\Memberships\Events\SubscriptionTrialUpgraded::class => [
            \Modules\Memberships\Listeners\Emails\SendTrialUpgradedEmail::class,
        ],

        // When a subscription is almost ended
        \Modules\Memberships\Events\SubscriptionAlmostEnded::class => [
            \Modules\Memberships\Listeners\Emails\SendAlmostEndedEmail::class,
        ],

        // When a subscription has ended
        \Modules\Memberships\Events\SubscriptionEnded::class => [
            \Modules\Memberships\Listeners\Emails\SendEndedEmail::class,
        ],

        // When a subscription is renewed (auto-renew)
        \Modules\Memberships\Events\SubscriptionIsRenewed::class => [
            \Modules\Memberships\Listeners\Emails\SendRenewedEmail::class,
        ],

        \Modules\Memberships\Events\SubscriptionGrace::class => [
            \Modules\Memberships\Listeners\Emails\SendGraceEmail::class,
        ],


        // Existing events from your app
        \Modules\Crm\Events\UserActivated::class => [
            \Modules\Memberships\Listeners\HandleSubscriptionAutoUpgrade::class,
        ],

        \Modules\Crm\Events\UserLoggedIn::class => [
            \Modules\Memberships\Listeners\Meta\CheckActivePlanSubscriptions::class,
        ],

        \Modules\Crm\Events\Auth\UserAfterAuthenticated::class => [
            \Modules\Memberships\Listeners\Meta\SetUserHeaders::class,
        ]
        
    ];
}
