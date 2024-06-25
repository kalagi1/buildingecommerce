<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UpdateHousingReorderTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Housing types tablosundaki tüm satırları çekiyoruz
        $housingTypes = DB::table('housing_types')->get();

        foreach ($housingTypes as $housingType) {
            $formJson = json_decode($housingType->form_json, true);

            // JSON içindeki elemanların sıraya koymak için yeniden düzenle
            $formJson = $this->reorderElements($formJson);

            // Güncellenmiş JSON'u tekrar encode ediyoruz
            $updatedFormJson = json_encode($formJson);

            // Veritabanındaki ilgili satırı güncelliyoruz
            DB::table('housing_types')
                ->where('id', $housingType->id)
                ->update(['form_json' => $updatedFormJson]);
        }
    }

    /**
     * Elemanları yeniden sıraya koymak için yardımcı fonksiyon
     *
     * @param array $formJson
     * @return array
     */
    private function reorderElements($formJson)
    {
        $desiredOrder = [
            'open_sharing[]',
            'discount_rate[]'
        ];

        $newFormJson = [];
        $remainingElements = [];

        // JSON içindeki elemanları sıraya göre düzenle
        foreach ($formJson as $element) {
            // İstenen sıra içinde mi diye kontrol et
            if (in_array($element['name'], $desiredOrder)) {
                $newFormJson[] = $element;
            } else {
                $remainingElements[] = $element;
            }
        }

        // Kalan elemanları sıralı olarak ekleyin
        $newFormJson = array_merge($newFormJson, $remainingElements);

        return $newFormJson;
    }
}
