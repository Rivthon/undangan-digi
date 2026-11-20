<?php

namespace Tests\Feature;

use App\Models\Invitation;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use LazilyRefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/?to=Budi');

        $response->assertStatus(200);
        $response->assertSee('Budi');
        $response->assertSee('Alya');
    }

    public function test_guest_can_submit_rsvp(): void
    {
        $invitation = Invitation::factory()->create();

        $response = $this->post(route('invitation.rsvp', $invitation), [
            'name' => 'Tamu Test',
            'attendance' => 'hadir',
            'guest_count' => 2,
            'message' => 'Semoga menjadi keluarga yang bahagia.',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('guest_messages', ['invitation_id' => $invitation->id, 'name' => 'Tamu Test']);
    }
}
