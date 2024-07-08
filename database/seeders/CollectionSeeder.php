<?php

namespace Database\Seeders;

use App\Models\Collection;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CollectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $collections = Collection::with("links")->get();
        foreach ($collections as $collection) {
            if (count($collection->links) == 0) {
                $collection->delete();
                
            }
        }
    }
}
