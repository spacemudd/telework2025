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
        // Universal Job Categories (Departments) that exist across all industries
        $categories = [
            [
                'name' => 'Human Resources',
                'name_ar' => 'الموارد البشرية',
                'icon_svg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M15 7a3 3 0 11-6 0 3 3 0 016 0z" />',
            ],
            [
                'name' => 'Administration',
                'name_ar' => 'الإدارة',
                'icon_svg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6M8 6h8a2 2 0 012 2v10a2 2 0 01-2 2H8a2 2 0 01-2-2V8a2 2 0 012-2z" />',
            ],
            [
                'name' => 'Accounting',
                'name_ar' => 'المحاسبة',
                'icon_svg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v8m-4-4h8m5 0a9 9 0 11-18 0 9 9 0 0118 0z" />',
            ],
            [
                'name' => 'IT & Technology',
                'name_ar' => 'تقنية المعلومات',
                'icon_svg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16v8H4V6zm0 12h16M8 10h.01M12 10h.01M16 10h.01" />',
            ],
            [
                'name' => 'Operations',
                'name_ar' => 'العمليات',
                'icon_svg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />',
            ],
            [
                'name' => 'Quality Assurance',
                'name_ar' => 'ضمان الجودة',
                'icon_svg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />',
            ],
            [
                'name' => 'Legal',
                'name_ar' => 'القانونية',
                'icon_svg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 0V5m0 2h2m-2 0h-2" />',
            ],
            [
                'name' => 'Marketing',
                'name_ar' => 'التسويق',
                'icon_svg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />',
            ],
            [
                'name' => 'Customer Service',
                'name_ar' => 'خدمة العملاء',
                'icon_svg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 13V8a6 6 0 10-12 0v5m0 0a3 3 0 106 0m-6 0v5a3 3 0 006 0" />',
            ],
            [
                'name' => 'Procurement',
                'name_ar' => 'المشتريات',
                'icon_svg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />',
            ],
            [
                'name' => 'Facilities Management',
                'name_ar' => 'إدارة المرافق',
                'icon_svg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l9-7 9 7v7a2 2 0 01-2 2h-4v-6H9v6H5a2 2 0 01-2-2v-7z" />',
            ],
            [
                'name' => 'Training & Development',
                'name_ar' => 'التدريب والتطوير',
                'icon_svg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />',
            ],
            [
                'name' => 'Research & Development',
                'name_ar' => 'البحث والتطوير',
                'icon_svg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />',
            ],
            [
                'name' => 'Sales',
                'name_ar' => 'المبيعات',
                'icon_svg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h18M3 8h18M3 13h18M3 18h18" />',
            ],
            [
                'name' => 'Finance',
                'name_ar' => 'المالية',
                'icon_svg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16v4H4V6zm0 8h16M6 18h.01M10 18h.01M14 18h.01M18 18h.01" />',
            ],
        ];

        foreach ($categories as $category) {
            JobCategory::firstOrCreate(
                ['slug' => Str::slug($category['name'])],
                [
                    'name' => $category['name'],
                    'name_ar' => $category['name_ar'],
                    'icon_svg' => $category['icon_svg'],
                    'is_active' => true,
                ]
            );
        }
    }
}
