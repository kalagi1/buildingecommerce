<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProjectHousing>
 */
class ProjectHousingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $keys = ['Kapak Resmi', 'Satışa Kapat', 'heating[]'];
        $names = ['image[]', 'off_sale[]', 'heating[]'];
        $values = [
            'master-doga-koy-evleri-project-housing-image-1712420580.jpeg',
            '[]',
            'Yerden Isıtma'
        ];

        return [
            'key' => $this->faker->shuffle($keys)[0],
            'name' => $this->faker->shuffle($names)[0],
            'value' => $this->faker->shuffle($values)[0],
            'project_id' => Project::factory(),
            'room_order' => $this->faker->numberBetween(1, 10),
            'created_at' => now(),
            'updated_at' => now(),
            'has_block' => false,
        ];
    }
}

