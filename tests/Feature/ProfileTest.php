<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_page_is_displayed(): void
    {
        $users = User::factory()->create();

        $response = $this
            ->actingAs($users)
            ->get('/profile');

        $response->assertOk();
    }

    public function test_profile_information_can_be_updated(): void
    {
        $users = User::factory()->create();

        $response = $this
            ->actingAs($users)
            ->patch('/profile', [
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/profile');

        $users->refresh();

        $this->assertSame('Test User', $users->name);
        $this->assertSame('test@example.com', $users->email);
        $this->assertNull($users->email_verified_at);
    }

    public function test_email_verification_status_is_unchanged_when_the_email_address_is_unchanged(): void
    {
        $users = User::factory()->create();

        $response = $this
            ->actingAs($users)
            ->patch('/profile', [
                'name' => 'Test User',
                'email' => $users->email,
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/profile');

        $this->assertNotNull($users->refresh()->email_verified_at);
    }

    public function test_user_can_delete_their_account(): void
    {
        $users = User::factory()->create();

        $response = $this
            ->actingAs($users)
            ->delete('/profile', [
                'password' => 'password',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/');

        $this->assertGuest();
        $this->assertNull($users->fresh());
    }

    public function test_correct_password_must_be_provided_to_delete_account(): void
    {
        $users = User::factory()->create();

        $response = $this
            ->actingAs($users)
            ->from('/profile')
            ->delete('/profile', [
                'password' => 'wrong-password',
            ]);

        $response
            ->assertSessionHasErrorsIn('userDeletion', 'password')
            ->assertRedirect('/profile');

        $this->assertNotNull($users->fresh());
    }
}
