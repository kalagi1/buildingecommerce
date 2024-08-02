<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CookiePreferenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('cookie_preferences')->insert([
            [
                'cookie_name' => 'privacy',
                'site_domain' => 'example.com',
                'description' => 'Bu çerezler, kullanıcı gizliliğini korumak için kullanılır.',
                'expiry_duration' => 365, // Geçerlilik süresi, gün cinsinden
                'cookie_type' => 'privacy',
            ],
            [
                'cookie_name' => 'targeting',
                'site_domain' => 'example.com',
                'description' => 'Hedefleme amaçlı çerezler, ilgili reklamları göstermek için kullanılır.',
                'expiry_duration' => 30,
                'cookie_type' => 'targeting',
            ],
            [
                'cookie_name' => 'essential',
                'site_domain' => 'example.com',
                'description' => 'Bu çerezler, web sitesinin çalışması için gereklidir.',
                'expiry_duration' => 0, // Süresiz
                'cookie_type' => 'essential',
            ],
            [
                'cookie_name' => 'functional',
                'site_domain' => 'example.com',
                'description' => 'İşlevsel çerezler, kullanıcı deneyimini iyileştirmek için kullanılır.',
                'expiry_duration' => 90,
                'cookie_type' => 'functional',
            ],
            [
                'cookie_name' => 'performance',
                'site_domain' => 'example.com',
                'description' => 'Performans çerezleri, site performansını izlemek için kullanılır.',
                'expiry_duration' => 30,
                'cookie_type' => 'performance',
            ],
        ]);
    }
}
