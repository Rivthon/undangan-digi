<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use DatabaseTransactions;

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
        $response = $this->post('/rsvp', [
            'name' => 'Tamu Test',
            'attendance' => 'hadir',
            'guest_count' => 2,
            'message' => 'Semoga menjadi keluarga yang bahagia.',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('guest_messages', ['name' => 'Tamu Test']);
    }
}
