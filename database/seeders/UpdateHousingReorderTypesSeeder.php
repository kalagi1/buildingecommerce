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

            // JSON içindeki elemanların sırasını güncelle
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
        $discountElement = null;
        $newFormJson = [];

        foreach ($formJson as $element) {
            if (isset($element['label']) && $element['label'] === 'İndirim Oranı %') {
                $discountElement = $element;
            } else {
                $newFormJson[] = $element;
                if (isset($element['label']) && $element['label'] === 'Paylaşıma Açık') {
                    if ($discountElement !== null) {
                        $newFormJson[] = $discountElement;
                        $discountElement = null;
                    }
                }
            }
        }

        // Eğer discountElement hala null değilse, en sona ekle
        if ($discountElement !== null) {
            $newFormJson[] = $discountElement;
        }

        return $newFormJson;
    }
}
