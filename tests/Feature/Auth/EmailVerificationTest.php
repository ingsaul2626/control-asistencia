<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class EmailVerificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_email_verification_screen_can_be_rendered(): void
    {
        $users = User::factory()->unverified()->create();

        $response = $this->actingAs($users)->get('/verify-email');

        $response->assertStatus(200);
    }

    public function test_email_can_be_verified(): void
    {
        $users = User::factory()->unverified()->create();

        Event::fake();

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $users->id, 'hash' => sha1($users->email)]
        );

        $response = $this->actingAs($users)->get($verificationUrl);

        Event::assertDispatched(Verified::class);
        $this->assertTrue($users->fresh()->hasVerifiedEmail());
        $response->assertRedirect(route('dashboard', absolute: false).'?verified=1');
    }

    public function test_email_is_not_verified_with_invalid_hash(): void
    {
        $users = User::factory()->unverified()->create();

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $users->id, 'hash' => sha1('wrong-email')]
        );

        $this->actingAs($users)->get($verificationUrl);

        $this->assertFalse($users->fresh()->hasVerifiedEmail());
    }
}
