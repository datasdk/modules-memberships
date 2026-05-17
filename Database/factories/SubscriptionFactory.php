<?php

namespace Modules\Memberships\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Modules\Memberships\Models\Subscription;
use Modules\Memberships\Models\Plan;
use Carbon\Carbon;

class SubscriptionFactory extends Factory
{
    protected $model = Subscription::class;

    public function definition(): array
    {
        return [
            'name' => 'main',
            'subscribable_id' => 1,
            'subscribable_type' => 'App\\Models\\User', // default type
            'plan_id' => Plan::factory(),
            'description' => [
                'en' => $this->faker->sentence(),
            ],
            'timezone' => $this->faker->timezone(),
            'payment_method' => $this->faker->randomElement(['credit_card', 'paypal', 'bank_transfer']),
            'payment_status' => $this->faker->randomElement(['pending', 'paid', 'failed']),
            'paid_at' => $this->faker->boolean(70) ? Carbon::now()->subDays(rand(1, 10)) : null,

            'has_trial' => $this->faker->boolean(),
            'permanent_membership' => $this->faker->boolean(),
            'trial_ends_at' => Carbon::now()->addDays(7),
            'starts_at' => Carbon::now(),
            'ends_at' => Carbon::now()->addMonths(1),
            'auto_renew' => $this->faker->boolean(),
            'trial_auto_upgrade' => $this->faker->boolean(),
            'cancels_at' => null,
            'canceled_at' => null,
        ];
    }

    /**
     * State: active subscription.
     */
    public function active(): static
    {
        return $this->state(fn() => [
            'payment_status' => 'paid',
            'starts_at' => now()->subMonth(),
            'ends_at' => now()->addMonth(),
            'auto_renew' => true,
        ]);
    }

    /**
     * State: canceled subscription.
     */
    public function canceled(): static
    {
        return $this->state(fn() => [
            'payment_status' => 'failed',
            'canceled_at' => now(),
            'auto_renew' => false,
        ]);
    }
}
