<?php

namespace Database\Factories;

use App\Models\GuestMessage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<GuestMessage>
 */
class GuestMessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'attendance' => fake()->randomElement(['hadir', 'tidak_hadir', 'masih_ragu']),
            'guest_count' => fake()->numberBetween(1, 5),
            'message' => fake()->sentence(),
        ];
    }
}
