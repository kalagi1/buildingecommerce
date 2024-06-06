<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str; 
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Housing>
 */
class HousingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        
        return [
            'description' => $this->faker->paragraph,
            'step1_slug' => 'konut',
            'step2_slug' => 'satilik',
            'housing_type_id' => 1,
            'status_id' => 1,
            'user_id' => 696,
            'housing_type_data' => json_encode([
                'price' => [293],
                'm2gross' => [23],
                'squaremeters' => [323],
                'gardenm' => [342424],
                'room_count' => ['1.5+1'],
                'buildingage' => [2],
                'floorlocation' => [1],
                'heating' => ['Merkezi'],
                'numberofbathrooms' => [2],
                'usingstatus' => ['Boş'],
                'titledeedstatus' => ['Müstakil Tapulu'],
                'internal_features' => ['Boyalı', 'Ebeveyn Banyosu', 'Mobilya'],
                'external_features' => ['Müstakil Havuzlu'],
                'image' => 'bu-havada-gidilmez-gunesli-gunde-gidilmez_housing_cover_image_1717513154.jpg',
                'images' => ['bu-havada-gidilmez-gunesli-gunde-gidilmez_housing_gallery_image_01717513154.jpg'],
                'open_sharing1' => 'Evet',
            ]),
            
            'title' => $this->faker->sentence,
            'address' => $this->faker->address,
            'latitude' => $this->faker->latitude,
            'longitude' => $this->faker->longitude,
            'view_count' => $this->faker->numberBetween(0, 100),
            'order' => 0,
            // 'brand_id' => $this->faker->numberBetween(1, 10),
            'city_id' => $this->faker->numberBetween(1, 10),
            'county_id' =>1301,
            'status' => 1,
            'document' =>  'ea-reprehenderit-ut_housing_document_1717505559.jpg',
            'slug' => Str::slug($this->faker->unique()->sentence),
            'neighborhood_id' =>7442,
            'views_count' => $this->faker->numberBetween(0, 100),
            'authority_certificate' => 'ea-reprehenderit-ut_housing_document_1717505559.jpg',
            'island' => $this->faker->word,
            'parcel' => $this->faker->word,
            'deleteReason' => $this->faker->sentence,
            'is_share' => $this->faker->boolean,
            'owner_id' => $this->faker->numberBetween(1, 10),
            // 'is_sold' => $this->faker->boolean,
            // 'consultant_id' => $this->faker->numberBetween(1, 10),
        ];
    }
}
