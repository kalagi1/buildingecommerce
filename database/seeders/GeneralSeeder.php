<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Housing;
use App\Models\Project;
use App\Models\HousingStatusConnection;
use App\Models\ProjectHousing;
class GeneralSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $housings = Housing::factory()->count(10000)->create();

        $housings->each(function ($housing) {
            HousingStatusConnection::create([
                'housing_id' => $housing->id,
                'housing_status_id' => 4,
            ]);
        });

        // Project::factory()->count(50)->create();
        // ProjectHousing::factory()->count(1)->create();




$keys = ['Kapak Resmi', 'Satışa Kapat', 'Isıtma', 'fiyat'];
$names = ['image[]', 'off_sale[]', 'heating[]', 'price[]'];
$values = [
    'master-doga-koy-evleri-project-housing-image-1712420580.jpeg',
    '["Satışa Kapalı"]',
    'Yerden Isıtma',
    '234242',
];


Project::factory(10000)->create()->each(function ($project) use ($keys, $names, $values) {
    // Her bir anahtar, isim ve değer için indeksleri takip eden değişkenler
    $keyIndex = 0;
    $nameIndex = 0;
    $valueIndex = 0;

    // room_order değeri için bir sayaç
    $roomOrder = 1;

    // Toplam kaç öğe ekleyeceğimizi belirleyen değişken
    $totalItems = count($keys) * 10000; // Her anahtar için 4 öğe ekleyeceğiz

    // Her projenin room_count değerini takip etmek için bir değişken
    $projectRoomCount = 0;

    // Her bir öğe için
    for ($i = 1; $i <= $totalItems; $i++) {
        // Her bir anahtar, isim ve değeri kullanarak bir ProjectHousing oluştur
        ProjectHousing::create([
            'key' => $keys[$keyIndex],
            'name' => $names[$nameIndex],
            'value' => $values[$valueIndex],
            'project_id' => $project->id,
            'room_order' => $roomOrder, // room_order değeri artarak devam edecek
            'created_at' => now(),
            'updated_at' => now(),
            'has_block' => false,
        ]);

        // Indeksleri bir sonraki öğeye geç
        $keyIndex++;
        $nameIndex++;
        $valueIndex++;

        // Indekslerin dizi boyutuna ulaştığını kontrol et ve sıfırla
        if ($keyIndex >= count($keys)) {
            $keyIndex = 0;
        }
        if ($nameIndex >= count($names)) {
            $nameIndex = 0;
        }
        if ($valueIndex >= count($values)) {
            $valueIndex = 0;
        }

        // Eğer döngü 4'te tam bölünüyorsa, room_order değerini artır
        if ($i % 4 == 0) {
            $roomOrder++;
            // Her dört öğe ekledikten sonra projenin room_count değerini artır
            $projectRoomCount++;
        }
    }

    // Projeye ait room_count değerini güncelle
    $project->update(['room_count' => $projectRoomCount]);
});


        
    }
}
