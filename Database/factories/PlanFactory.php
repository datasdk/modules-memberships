<?php

namespace Modules\Memberships\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Laravelcm\Subscriptions\Interval;
use Modules\Memberships\Models\Plan;

class PlanFactory extends Factory
{
    protected $model = Plan::class;

    public function definition(): array
    {
        $title = $this->faker->unique()->words(2, true);

        return [
            'title' => $this->faker->sentence(),
            'description' => $this->faker->sentence(),
            'slug' => Str::slug($title),

            'price' => $this->faker->randomFloat(2, 0, 9999),
            'signup_fee' => $this->faker->randomFloat(2, 0, 500),
            'currency' => 'DKK',

            'permanent_membership' => $this->faker->boolean(20),
            'auto_renew' => $this->faker->boolean(50),

            'has_trial' => $this->faker->boolean(30),
            'trial_period' => $this->faker->numberBetween(0, 30),
            'trial_interval' => Interval::DAY->value,
            'trial_auto_upgrade' => $this->faker->boolean(30),

            'invoice_period' => $this->faker->numberBetween(1, 12),
            'invoice_interval' => Interval::MONTH->value,
            'grace_period' => $this->faker->numberBetween(0, 7),
            'grace_interval' => Interval::DAY->value,

            'prorate_day' => $this->faker->optional()->numberBetween(1, 28),
            'prorate_period' => $this->faker->optional()->numberBetween(1, 12),
            'prorate_extend_due' => $this->faker->optional()->numberBetween(1, 12),
            'active_subscribers_limit' => $this->faker->optional()->numberBetween(10, 1000),

            'active' => $this->faker->boolean(90),
            'sorting' => $this->faker->numberBetween(1, 100),
        ];
    }

    /**
     * State til at sætte et specifikt titel-navn (både da/en).
     */
    public function withTitle(string $title): static
    {
        return $this->state(fn() => [
            'title' => $this->faker->sentence(),
            'slug' => Str::slug($title),
        ]);
    }
}
