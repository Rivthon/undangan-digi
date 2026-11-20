<?php

namespace Tests\Feature;

use App\Models\GuestMessage;
use App\Models\Invitation;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class TenantInvitationTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_public_invitation_displays_only_selected_couple(): void
    {
        $invitation = Invitation::factory()->create([
            'slug' => 'alya-raka',
            'bride_name' => 'Alya Milik Pelanggan',
        ]);

        $response = $this->get(route('invitation.show', $invitation));

        $response->assertOk();
        $response->assertSee('Alya Milik Pelanggan');
    }

    public function test_rsvp_is_stored_for_invitation_from_public_url(): void
    {
        $invitation = Invitation::factory()->create();

        $response = $this->post(route('invitation.rsvp', $invitation), [
            'name' => 'Tamu Pelanggan',
            'attendance' => 'hadir',
            'guest_count' => 2,
            'message' => 'Selamat berbahagia.',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('guest_messages', [
            'invitation_id' => $invitation->id,
            'name' => 'Tamu Pelanggan',
        ]);
    }

    public function test_admin_dashboard_does_not_show_another_customers_rsvp(): void
    {
        $owner = User::factory()->admin()->create();
        $ownerInvitation = Invitation::factory()->for($owner)->create();
        GuestMessage::factory()->for($ownerInvitation)->create(['name' => 'Tamu Milik Sendiri']);
        GuestMessage::factory()->create(['name' => 'Tamu Rahasia Pelanggan Lain']);

        $response = $this->actingAs($owner)->get(route('admin.dashboard'));

        $response->assertOk();
        $response->assertSee('Tamu Milik Sendiri');
        $response->assertDontSee('Tamu Rahasia Pelanggan Lain');
    }

    public function test_admin_cannot_delete_another_customers_rsvp(): void
    {
        $owner = User::factory()->admin()->create();
        Invitation::factory()->for($owner)->create();
        $otherMessage = GuestMessage::factory()->create();

        $this->actingAs($owner)
            ->delete(route('admin.rsvp.destroy', $otherMessage))
            ->assertNotFound();

        $this->assertModelExists($otherMessage);
    }

    public function test_super_admin_dashboard_does_not_expose_customer_rsvp(): void
    {
        $superAdmin = User::factory()->superAdmin()->create();
        GuestMessage::factory()->create(['name' => 'Nama Tamu Privat']);

        $response = $this->actingAs($superAdmin)->get(route('admin.dashboard'));

        $response->assertOk();
        $response->assertSee('Privasi pelanggan terlindungi');
        $response->assertDontSee('Nama Tamu Privat');
    }

    public function test_admin_can_update_their_invitation_settings(): void
    {
        $admin = User::factory()->admin()->create();
        $invitation = Invitation::factory()->for($admin)->create();
        $payload = $invitation->only([
            'slug', 'bride_name', 'bride_short_name', 'bride_parents', 'bride_instagram',
            'groom_name', 'groom_short_name', 'groom_parents', 'groom_instagram', 'display_date',
            'akad_time', 'reception_time', 'venue', 'address', 'maps_url', 'quote',
        ]);
        $payload['event_at'] = '2027-08-17 09:00:00';
        $payload['venue'] = 'Gedung Milik Pelanggan';

        $response = $this->actingAs($admin)->put(route('admin.invitation.update'), $payload);

        $response->assertRedirect(route('admin.invitation.edit'));
        $this->assertDatabaseHas('invitations', [
            'id' => $invitation->id,
            'venue' => 'Gedung Milik Pelanggan',
        ]);
    }
}
