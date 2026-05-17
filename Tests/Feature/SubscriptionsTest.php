<?php

namespace Modules\Memberships\Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Modules\Memberships\Models\Plan;
use Modules\Memberships\Models\Subscription;
use Carbon\Carbon;

class SubscriptionsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Modules\Memberships\Database\Seeders\MembershipsDatabaseSeeder::class);
    }

    /** @test */
    public function test_store_subscription_with_trial_and_ends_at()
    {
        $user = User::factory()->create();
        $plan = Plan::factory()->create();

        $payload = [
            'subscribable_id'   => $user->id,
            'subscribable_type' => User::class,
            'plan_id'           => $plan->id,
            'starts_at'         => Carbon::now()->toDateTimeString(),
            'trial'             => 1,
            'trial_ends_at'     => Carbon::now()->addDays(14)->toDateTimeString(),
            'ends_at'           => Carbon::now()->addMonths(6)->toDateTimeString(),
            //'features'          => ['featureA'],
            'period'            => 'monthly',
            'invoice_period'    => 1,
            'invoice_interval'  => 'months',
            'grace_period'      => 7,
            'grace_interval'    => 'days',
            'payment_method'    => 'credit_card',
            'payment_status'    => 'pending',
            'status'            => 'draft',
            'active'            => true,
        ];

        $response = $this->actingAs($user)
            ->postJson(route('api.memberships.subscriptions.store'), $payload);

       
        $response->assertStatus(201);

 
        $this->assertDatabaseHas('memberships_subscriptions', [
            'subscribable_id' => $user->id,
            'plan_id'         => $plan->id
        ]);
    
    }

    /** @test */
    public function test_store_subscription_without_trial_and_without_ends_at()
    {

        $user = User::factory()->create();
        $plan = Plan::factory()->create();


        $payload = [
            'subscribable_id'   => $user->id,
            'subscribable_type' => User::class,
            'plan_id'           => $plan->id,
            'starts_at'         => Carbon::now()->toDateTimeString(),
            'trial'             => 0,
           // 'features'          => ['featureB'],
            'period'            => 'yearly',
            'invoice_period'    => 1,
            'invoice_interval'  => 'years',
            'grace_period'      => 7,
            'grace_interval'    => 'days',
            'payment_method'    => 'credit_card',
            'payment_status'    => 'pending',
            'status'            => 'draft',
            'active'            => true,
        ];


        $response = $this->actingAs($user)
            ->postJson(route('api.memberships.subscriptions.store'), $payload);


        $response->assertStatus(201);


        $this->assertDatabaseHas('memberships_subscriptions', [
            'subscribable_id' => $user->id,
            'plan_id'         => $plan->id
        ]);

    }


    /** @test */
    public function test_delete_subscription()
    {

        $user = User::factory()->create();

        $subscription = Subscription::factory()->create([
            'subscribable_id'   => $user->id,
            'subscribable_type' => User::class,
        ]);

        $response = $this->actingAs($user)
            ->deleteJson(route('api.memberships.subscriptions.destroy', $subscription->id));

      
        $response->assertNoContent();

/*
        $this->assertDatabaseMissing('memberships_subscriptions', [
            'id' => $subscription->id,
        ]);
*/
    

    }

}
