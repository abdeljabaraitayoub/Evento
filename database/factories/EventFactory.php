<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->name(),
            'description' => $this->faker->text(),
            'start_date' => $this->faker->dateTime(),
            'location' => $this->faker->address(),
            'category_id' => $this->faker->numberBetween(1, 10),
            'user_id' => $this->faker->numberBetween(1, 10),
            'capacity' => $this->faker->numberBetween(10, 1000),
            'region_id' => $this->faker->numberBetween(1, 10),
        ];
    }
}
