<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Sector;
use Illuminate\Support\Str;

class SectorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            ['الزراعة والصناعات الغذائية', '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7l9 6 9-6-9-4-9 4zm0 0v10l9 4 9-4V7" />'],
            ['الطاقة', '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />'],
            ['الرعاية الصحية وعلوم الحياة', '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3M3 11h18M5 19h14a2 2 0 002-2v-6H3v6a2 2 0 002 2zm7-6v6" />'],
            ['الخدمات البيئية', '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6c-3 4-6 5-6 9a6 6 0 0012 0c0-4-3-5-6-9z" />'],
            ['الصناعة والتصنيع', '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 13l9-5 9 5-9 5-9-5zm0 0V7l9 5 9-5v6" />'],
            ['الأدوية والتكنولوجيا الحيوية', '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11a5 5 0 1010 0A5 5 0 007 11zm5-9v4m0 12v4m-9-9h4m10 0h4" />'],
            ['الكيماويات', '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 3h12l-4 6v9a2 2 0 11-4 0V9L6 3z" />'],
            ['العقارات', '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l9-7 9 7v7a2 2 0 01-2 2h-4v-6H9v6H5a2 2 0 01-2-2v-7z" />'],
            ['الخدمات المالية', '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16v4H4V6zm0 8h16M6 18h.01M10 18h.01M14 18h.01M18 18h.01" />'],
            ['النقل والخدمات اللوجستية', '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h13l5 5v5a2 2 0 01-2 2h-1M3 7v10a2 2 0 002 2h8M3 7l3 5h10" />'],
            ['التعدين والمعادن', '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 13l9-9 9 9-9 9-9-9zm9-5l5 5-5 5-5-5 5-5z" />'],
            ['السياحة وجودة الحياة', '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21l9-18 9 18H3zm6-4h6" />'],
            ['المعلومات وتقنية الاتصالات', '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16v8H4V6zm0 12h16M8 10h.01M12 10h.01M16 10h.01" />'],
            ['رأس المال البشري والابتكار', '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14a5 5 0 100-10 5 5 0 000 10zm-7 7a7 7 0 0114 0H5z" />'],
            ['الطيران والدفاع', '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2 16l8-2 4 4 6-14-14 6 4 4-2 8-6-6z" />'],
        ];

        foreach ($items as [$ar, $icon]) {
            $slug = Str::slug($ar);
            if (empty($slug)) {
                $slug = 'sector-'.Str::lower(Str::random(8));
            }

            Sector::updateOrCreate(
                ['name_ar' => $ar],
                [
                    'name' => $ar,
                    'name_ar' => $ar,
                    'slug' => $slug,
                    'icon_svg' => $icon,
                    'is_active' => true,
                ]
            );
        }
    }
}
