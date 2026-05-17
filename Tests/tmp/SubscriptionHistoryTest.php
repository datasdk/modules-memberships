<?php

namespace Modules\Memberships\Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

class SubscriptionHistoryTest extends TestCase
{

    use RefreshDatabase;

    /**
     * Test at insights returneres.
     */
    public function test_insights_index()
    {
        $user = User::factory()->create();
    
        // Antag ruten for insights er 'api.memberships.insight.index'
        $response = $this->actingAs($user)->getJson(route('api.memberships.customers.index'));

        $response->assertStatus(200);

    }
    
}
