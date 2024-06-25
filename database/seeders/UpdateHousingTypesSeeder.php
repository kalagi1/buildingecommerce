<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UpdateHousingTypesSeeder extends Seeder
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

            // JSON içindeki her bir öğenin label ve placeholder değerini güncelliyoruz
            foreach ($formJson as &$item) {
                if (isset($item['label'])) {
                    $item['label'] = $this->updateLabel($item['label']);
                }
                if (isset($item['placeholder'])) {
                    $item['placeholder'] = $this->updatePlaceholder($item['placeholder']);
                }
            }

            // Güncellenmiş JSON'u tekrar encode ediyoruz
            $updatedFormJson = json_encode($formJson);

            // Veritabanındaki ilgili satırı güncelliyoruz
            DB::table('housing_types')
                ->where('id', $housingType->id)
                ->update(['form_json' => $updatedFormJson]);
        }
    }

    /**
     * Label değerini güncellemek için yardımcı fonksiyon
     *
     * @param string $label
     * @return string
     */
    private function updateLabel($label)
    {
        // Özel label güncellemeleri
        if ($label === 'Satış Yetkisi Bitiş Tarihi') {
            return 'Yetki Bitiş Tarihi';
        }

        // Diğer label'lar için aynı kalacak
        return $label;
    }

    /**
     * Placeholder değerini güncellemek için yardımcı fonksiyon
     *
     * @param string $placeholder
     * @return string
     */
    private function updatePlaceholder($placeholder)
    {
        // Özel placeholder güncellemeleri
        if ($placeholder === 'Satış Yetkisi Bitiş Tarihi') {
            return 'Yetki Bitiş Tarihi';
        }

        // Diğer placeholder'lar için aynı kalacak
        return $placeholder;
    }
}
