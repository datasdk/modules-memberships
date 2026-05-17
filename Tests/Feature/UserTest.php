<?php

namespace Modules\Memberships\Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test at hentning af en bruger (med memberships.plan) virker.
     */
    public function test_show_user_with_membership()
    {
        $user = User::factory()->create();
     
        // Antag ruten for at hente den autentificerede bruger er f.eks. 'api.memberships.user.show'
        $response = $this->actingAs($user)->getJson(route('api.memberships.users.show', $user->id));

        $response->assertStatus(200);
    }

    /**
     * Test at oprettelse af en bruger virker.
     */
    public function test_create_user()
    {
        $userData = [
            'name' => 'Test User',
            'email' => 'testuser@example.com',
            'password' => 'password',
            'membership_plan' => 'basic',  // Assuming the user has a membership plan
        ];

        $response = $this->postJson(route('api.memberships.users.store'), $userData);

        $response->assertStatus(201);
    }

    /**
     * Test at opdatering af bruger virker.
     */
    public function test_update_user()
    {
        $user = User::factory()->create();

        $updatedData = [
            'name' => 'Updated User',
            'email' => $user->email,
            'password' => 'newpassword',  // Optionally, you can hash this password
            'membership_plan' => 'premium',  // Assuming the user has a membership plan
        ];

        $response = $this->actingAs($user)->putJson(route('api.memberships.users.update', $user->id), $updatedData);

        $response->assertStatus(200);
    }

    /**
     * Test at sletning af bruger virker.
     */
    public function test_delete_user()
    {
        $user = User::factory()->create();

        $user2 = User::factory()->create();

        $response = $this->actingAs($user)->deleteJson(route('api.memberships.users.destroy', $user->id));

        $response->assertNoContent();  // Assuming the response returns a 204 No Content on successful deletion
    }
}
