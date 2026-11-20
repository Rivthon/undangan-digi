<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class AdminUserManagementTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_super_admin_can_create_paid_admin_account(): void
    {
        $superAdmin = User::factory()->superAdmin()->create();

        $response = $this->actingAs($superAdmin)->post(route('admin.users.store'), [
            'name' => 'Pelanggan Baru',
            'email' => 'pelanggan@example.com',
            'password' => 'password-baru',
            'password_confirmation' => 'password-baru',
            'is_active' => true,
            'role' => 'super_admin',
            'payment_status' => 'refunded',
        ]);

        $response->assertRedirect(route('admin.users.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('users', [
            'email' => 'pelanggan@example.com',
            'role' => 'admin',
            'payment_status' => 'paid',
            'is_active' => true,
        ]);
        $customer = User::query()->where('email', 'pelanggan@example.com')->firstOrFail();
        $this->assertDatabaseHas('invitations', ['user_id' => $customer->id]);
    }

    public function test_regular_admin_cannot_access_admin_account_management(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->get(route('admin.users.index'))
            ->assertForbidden();
    }

    public function test_super_admin_can_refund_and_deactivate_admin(): void
    {
        $superAdmin = User::factory()->superAdmin()->create();
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($superAdmin)->put(route('admin.users.update', $admin), [
            'name' => $admin->name,
            'email' => $admin->email,
            'password' => '',
            'payment_status' => 'refunded',
            'is_active' => false,
        ]);

        $response->assertRedirect(route('admin.users.index'));

        $this->assertDatabaseHas('users', [
            'id' => $admin->id,
            'payment_status' => 'refunded',
            'paid_at' => null,
            'is_active' => false,
        ]);
    }

    public function test_super_admin_record_cannot_be_edited_through_customer_route(): void
    {
        $actor = User::factory()->superAdmin()->create();
        $otherSuperAdmin = User::factory()->superAdmin()->create();

        $this->actingAs($actor)
            ->get(route('admin.users.edit', $otherSuperAdmin))
            ->assertNotFound();
    }
}
