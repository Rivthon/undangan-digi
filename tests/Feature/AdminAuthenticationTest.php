<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class AdminAuthenticationTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_guest_is_redirected_to_login_from_dashboard(): void
    {
        $this->get(route('admin.dashboard'))
            ->assertRedirect(route('admin.login'));
    }

    public function test_active_paid_admin_can_log_in(): void
    {
        $admin = User::factory()->admin()->create([
            'email' => 'admin@example.com',
            'password' => 'secret-password',
        ]);

        $response = $this->post(route('admin.login.store'), [
            'email' => 'admin@example.com',
            'password' => 'secret-password',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($admin);
    }

    public function test_inactive_admin_cannot_log_in(): void
    {
        User::factory()->admin()->create([
            'email' => 'inactive@example.com',
            'password' => 'secret-password',
            'is_active' => false,
        ]);

        $response = $this->post(route('admin.login.store'), [
            'email' => 'inactive@example.com',
            'password' => 'secret-password',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_refunded_admin_cannot_log_in(): void
    {
        User::factory()->admin()->create([
            'email' => 'refunded@example.com',
            'password' => 'secret-password',
            'payment_status' => 'refunded',
            'paid_at' => null,
        ]);

        $response = $this->post(route('admin.login.store'), [
            'email' => 'refunded@example.com',
            'password' => 'secret-password',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_authenticated_admin_can_log_out(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->post(route('admin.logout'));

        $response->assertRedirect(route('admin.login'));
        $this->assertGuest();
    }
}
