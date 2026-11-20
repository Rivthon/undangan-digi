<?php

namespace Database\Factories;

use App\Models\Invitation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Invitation>
 */
class InvitationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->admin(),
            'slug' => Str::slug(fake()->unique()->words(2, true)),
            'bride_name' => fake()->name('female'),
            'bride_short_name' => fake()->firstName('female'),
            'bride_parents' => fake()->sentence(),
            'bride_instagram' => fake()->userName(),
            'groom_name' => fake()->name('male'),
            'groom_short_name' => fake()->firstName('male'),
            'groom_parents' => fake()->sentence(),
            'groom_instagram' => fake()->userName(),
            'event_at' => now()->addMonths(3),
            'display_date' => 'Minggu, 14 Februari 2027',
            'akad_time' => '08.00 – 10.00 WIB',
            'reception_time' => '11.00 – 14.00 WIB',
            'venue' => fake()->company(),
            'address' => fake()->address(),
            'maps_url' => 'https://maps.google.com/?q=Jakarta',
            'quote' => fake()->sentence(),
        ];
    }
}
