<?php

namespace Tests\Feature;

use App\Models\GuestMessage;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class AdminDashboardTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_admin_can_see_rsvp_statistics_and_escaped_message(): void
    {
        $admin = User::factory()->admin()->create();
        GuestMessage::factory()->create([
            'name' => '<script>alert("xss")</script>',
            'attendance' => 'hadir',
            'guest_count' => 3,
        ]);

        $response = $this->actingAs($admin)->get(route('admin.dashboard'));

        $response->assertOk();
        $response->assertSee('3');
        $response->assertSee('&lt;script&gt;', false);
        $response->assertDontSee('<script>alert("xss")</script>', false);
    }

    public function test_admin_can_delete_rsvp(): void
    {
        $admin = User::factory()->admin()->create();
        $message = GuestMessage::factory()->create();

        $response = $this->actingAs($admin)->delete(route('admin.rsvp.destroy', $message));

        $response->assertRedirect();
        $response->assertSessionHas('success');
        $this->assertModelMissing($message);
    }
}
