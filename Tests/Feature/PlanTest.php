<?php

namespace Modules\Memberships\Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Modules\Memberships\Models\Plan;

class PlanTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that a new plan can be created.
     */
    public function test_store_plan(): void
    {
        $user = User::factory()->create();

        $payload = [
            'title' => [
                'en' => 'Basic Plan',
            ],
            'description' => [
                'en' => 'A basic membership plan.',
            ],
            'slug' => 'basic-plan',
            'price' => 100,
            'signup_fee' => 0,
            'currency' => 'DKK',
            'permanent_membership' => false,
            'auto_renew' => true,
            'has_trial' => true,
            'trial_period' => 7,
            'trial_interval' => 'days',
            'invoice_period' => 1,
            'invoice_interval' => 'months',
            'grace_period' => 3,
            'grace_interval' => 'days',
            'active' => true,
        ];

        $response = $this->actingAs($user)->postJson(route('api.memberships.plans.store'), $payload);

        $response->assertStatus(201);

        $this->assertDatabaseHas('memberships_plans', [
            'price' => 100.00,
        ]);
    }

    /**
     * Test that an existing plan can be updated.
     */
    public function test_update_plan(): void
    {
        $user = User::factory()->create();

        $plan = Plan::factory()->create([
            'title' => [
                'en' => 'Old Plan',
            ],
            'description' => [
                'en' => 'Old description',
            ],
            'invoice_period' => 1,
            'invoice_interval' => 'months',
            'grace_period' => 3,
            'grace_interval' => 'days',
        ]);

        $payload = [
            'title' => [
                'en' => 'Updated Plan',
            ],
            'description' => [
                'en' => 'Updated description',
            ],
            'price' => 250,
            'auto_renew' => true,
            'has_trial' => false,
            'active' => true,
            'invoice_period' => 1,
            'invoice_interval' => 'months',
            'grace_period' => 3,
            'grace_interval' => 'days',
        ];

        $response = $this->actingAs($user)->putJson(route('api.memberships.plans.update', $plan->id), $payload);

        $response->assertStatus(200);

        $this->assertDatabaseHas('memberships_plans', [
            'id' => $plan->id,
            'price' => 250.00
        ]);
    }
}
