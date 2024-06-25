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
        // Retrieve all rows from the housing_types table
        $housingTypes = DB::table('housing_types')->get();

        foreach ($housingTypes as $housingType) {
            // Decode the form_json column value into an associative array
            $formJson = json_decode($housingType->form_json, true);

            // Modify the formJson array to move discount_rate[] after open_sharing[]
            $formJson = $this->moveDiscountRateAfterOpenSharing($formJson);

            // Encode the modified formJson array back to JSON format
            $updatedFormJson = json_encode($formJson);

            // Update the housing_types table with the updated form_json value
            DB::table('housing_types')
                ->where('id', $housingType->id)
                ->update(['form_json' => $updatedFormJson]);
        }
    }

    /**
     * Move discount_rate[] after open_sharing[] in the given formJson array.
     *
     * @param array $formJson
     * @return array
     */
    private function moveDiscountRateAfterOpenSharing($formJson)
    {
        $openSharingIndex = $this->findInsertIndex($formJson, 'open_sharing[]');
        $discountRateIndex = $this->findInsertIndex($formJson, 'discount_rate[]');

        // Ensure both elements are found before proceeding
        if ($openSharingIndex !== null && $discountRateIndex !== null) {
            // Remove discount_rate[] from its current position
            $discountRateItem = $formJson[$discountRateIndex];
            array_splice($formJson, $discountRateIndex, 1);

            // Find the correct position to insert discount_rate[] after open_sharing[]
            if ($discountRateIndex > $openSharingIndex) {
                $openSharingIndex++; // Increment index to maintain position after splice
            }

            // Insert discount_rate[] after open_sharing[]
            array_splice($formJson, $openSharingIndex + 1, 0, [$discountRateItem]);
        }

        return $formJson;
    }

    /**
     * Find the index of an element in the formJson array by its 'name' attribute.
     *
     * @param array $formJson
     * @param string $name
     * @return int|null
     */
    private function findInsertIndex($formJson, $name)
    {
        foreach ($formJson as $index => $element) {
            if (isset($element['name']) && $element['name'] === $name) {
                return $index;
            }
        }
        return null;
    }
}
