<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'housing_type_id' => "1",
            'step1_slug' => 'konut',
            'step2_slug' => "satilik",
            'user_id' =>"106",
            // 'brand_id' => $this->faker->numberBetween(1, 20),
            'room_count' => $this->faker->randomDigitNotNull,
            'project_title' => $this->faker->sentence,
            'slug' => $this->faker->slug,
            'description' => $this->faker->paragraph,
            'create_company' => $this->faker->company,
            'total_project_area' => $this->faker->numberBetween(100, 1000),
            'start_date' => $this->faker->date(),
            'project_end_date' => $this->faker->date(),
            'address' => $this->faker->address,
            'location' => $this->faker->latitude . ',' . $this->faker->longitude,
            'status_id' => $this->faker->numberBetween(1, 3),
            'have_blocks' => 0,
            'image' => $this->faker->imageUrl(),
            'city_id' => $this->faker->numberBetween(1, 10),
            'neighbourhood_id' => $this->faker->numberBetween(1, 10),
            'county_id' => 1301,
            'view_count' => $this->faker->numberBetween(0, 100),
            'order' => $this->faker->numberBetween(1, 100),
            'status' => 1,
            'document' => $this->faker->word,
            'end_date' => $this->faker->date(),
            'island' => 109,
            'parcel' => 1252,
            'deposit_rate' => $this->faker->numberBetween(1, 10),
            'club_rate' => $this->faker->numberBetween(1, 10),
        ];
    }
}
