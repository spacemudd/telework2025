<?php

namespace Database\Seeders;

use App\Models\JobCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class JobCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Sales',
                'name_ar' => 'المبيعات',
                'icon_svg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h18M3 8h18M3 13h18M3 18h18" />',
            ],
            [
                'name' => 'Accounting',
                'name_ar' => 'المحاسبة',
                'icon_svg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v8m-4-4h8m5 0a9 9 0 11-18 0 9 9 0 0118 0z" />',
            ],
            [
                'name' => 'Management',
                'name_ar' => 'الإدارة',
                'icon_svg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6M8 6h8a2 2 0 012 2v10a2 2 0 01-2 2H8a2 2 0 01-2-2V8a2 2 0 012-2z" />',
            ],
            [
                'name' => 'Human Resources',
                'name_ar' => 'الموارد البشرية',
                'icon_svg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M15 7a3 3 0 11-6 0 3 3 0 016 0z" />',
            ],
            [
                'name' => 'Customer Service',
                'name_ar' => 'خدمة العملاء',
                'icon_svg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 13V8a6 6 0 10-12 0v5m0 0a3 3 0 106 0m-6 0v5a3 3 0 006 0" />',
            ],
            [
                'name' => 'Restaurants & Cafes',
                'name_ar' => 'المطاعم و المقاهي',
                'icon_svg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M10 14h4m-7 4h10" />',
            ],
            [
                'name' => 'Travel & Tourism',
                'name_ar' => 'السفر والسياحة',
                'icon_svg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.5 6.5L21 3l-3.5 10.5-7 7L3 21l7.5-7z" />',
            ],
            [
                'name' => 'Retail & Services',
                'name_ar' => 'البيع التجزئة والخدمات',
                'icon_svg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />',
            ],
        ];

        foreach ($categories as $category) {
            JobCategory::create([
                'name' => $category['name'],
                'name_ar' => $category['name_ar'],
                'icon_svg' => $category['icon_svg'],
                'slug' => Str::slug($category['name']),
                'is_active' => true,
            ]);
        }
    }
}
