<?php

use Modules\Memberships\Models\Feature;
use Modules\Memberships\Models\Plan;
use Modules\Memberships\Models\Memberships;
use Modules\Memberships\Models\SubscriptionUsage;
use Modules\Memberships\Models\Subscription;

return [
    'name' => 'Memberships',

    'member_models' => [

    ],

    'admin' => [
        'navigationbar' => [

            "group" => "Memberships",
            "sorting" => 300,

            "link" => [
                "name" => "Memberships",
                "icon" => "fas fa-id-card",
                "link" => "memberships.subscriptions.index"
            ],

            "submenu" => [
        
                [
                    "name" => "Plans",
                    "icon" => "fas fa-layer-group",
                    "link" => "memberships.plans.index"
                ],
                [
                    "name" => "Settings",
                    "icon" => "fas fa-cog",
                    "link" => "memberships.settings.index"
                ],
            ]
        ],
    ],

    /*
    |----------------------------------------------------------------------
    | Subscription Tables
    |----------------------------------------------------------------------
    */
    'tables' => [
        'plans' => 'memberships_plans',
        'features' => 'memberships_features',
        'subscriptions' => 'memberships_subscriptions',
        'subscription_usage' => 'memberships_subscription_usage',
    ],

    /*
    |----------------------------------------------------------------------
    | Subscription Models
    |----------------------------------------------------------------------
    */
    'models' => [
        'plan' => Plan::class,
        'feature' => Feature::class,
        'subscription' => Subscription::class,
        'subscription_usage' => SubscriptionUsage::class,
    ],
];
