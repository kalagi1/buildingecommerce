<?php 

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Institution;

class InstitutionSeeder extends Seeder
{
    public function run()
    {
        // Örnek kurumlar
        $institutions = [
            ['name' => 'Emlak Ofisi'],
            ['name' => 'İnşaat Ofisi'],
            ['name' => 'Turizm Amaçlı Kiralama'],
            ['name' => 'Banka'],
            ['name' => 'Diğer'],
        ];

        foreach ($institutions as $institution) {
            Institution::create($institution);
        }
    }
}
