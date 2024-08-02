<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class MigrationStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Migrations dizininde bulunan tüm PHP dosyalarını al
        $migrationPath = database_path('migrations');
        $migrationFiles = File::files($migrationPath);

        foreach ($migrationFiles as $file) {
            // Dosya adını olduğu gibi al
            $fileName = $file->getFilename();
            
            // Migrations tablosunda bu migration'ın olup olmadığını kontrol et
            if (!DB::table('migrations')->where('migration', $fileName)->exists()) {
                // Eğer mevcut değilse, migration'ı kaydet
                DB::table('migrations')->insert([
                    'migration' => $fileName,
                    'batch' => 1, // Varsayılan batch numarası
                ]);
                $this->command->info("Migration '{$fileName}' added to migrations table.");
            } else {
                $this->command->info("Migration '{$fileName}' already exists in migrations table.");
            }
        }
    }
}
