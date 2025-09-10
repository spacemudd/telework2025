<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Skill;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $skills = [
            // Technical Skills (Not translatable)
            ['name' => 'Microsoft Office', 'name_ar' => null, 'is_translatable' => false, 'sort_order' => 1],
            ['name' => 'Excel', 'name_ar' => null, 'is_translatable' => false, 'sort_order' => 2],
            ['name' => 'PowerPoint', 'name_ar' => null, 'is_translatable' => false, 'sort_order' => 3],
            ['name' => 'Word', 'name_ar' => null, 'is_translatable' => false, 'sort_order' => 4],
            ['name' => 'Google Workspace', 'name_ar' => null, 'is_translatable' => false, 'sort_order' => 5],
            ['name' => 'Slack', 'name_ar' => null, 'is_translatable' => false, 'sort_order' => 6],
            ['name' => 'Zoom', 'name_ar' => null, 'is_translatable' => false, 'sort_order' => 7],
            ['name' => 'Teams', 'name_ar' => null, 'is_translatable' => false, 'sort_order' => 8],
            ['name' => 'Photoshop', 'name_ar' => null, 'is_translatable' => false, 'sort_order' => 9],
            ['name' => 'Illustrator', 'name_ar' => null, 'is_translatable' => false, 'sort_order' => 10],
            ['name' => 'Figma', 'name_ar' => null, 'is_translatable' => false, 'sort_order' => 11],
            ['name' => 'Canva', 'name_ar' => null, 'is_translatable' => false, 'sort_order' => 12],
            ['name' => 'HTML', 'name_ar' => null, 'is_translatable' => false, 'sort_order' => 13],
            ['name' => 'CSS', 'name_ar' => null, 'is_translatable' => false, 'sort_order' => 14],
            ['name' => 'JavaScript', 'name_ar' => null, 'is_translatable' => false, 'sort_order' => 15],
            ['name' => 'Python', 'name_ar' => null, 'is_translatable' => false, 'sort_order' => 16],
            ['name' => 'PHP', 'name_ar' => null, 'is_translatable' => false, 'sort_order' => 17],
            ['name' => 'Laravel', 'name_ar' => null, 'is_translatable' => false, 'sort_order' => 18],
            ['name' => 'React', 'name_ar' => null, 'is_translatable' => false, 'sort_order' => 19],
            ['name' => 'Vue.js', 'name_ar' => null, 'is_translatable' => false, 'sort_order' => 20],
            ['name' => 'Node.js', 'name_ar' => null, 'is_translatable' => false, 'sort_order' => 21],
            ['name' => 'MySQL', 'name_ar' => null, 'is_translatable' => false, 'sort_order' => 22],
            ['name' => 'PostgreSQL', 'name_ar' => null, 'is_translatable' => false, 'sort_order' => 23],
            ['name' => 'MongoDB', 'name_ar' => null, 'is_translatable' => false, 'sort_order' => 24],
            ['name' => 'Git', 'name_ar' => null, 'is_translatable' => false, 'sort_order' => 25],
            ['name' => 'Docker', 'name_ar' => null, 'is_translatable' => false, 'sort_order' => 26],
            ['name' => 'AWS', 'name_ar' => null, 'is_translatable' => false, 'sort_order' => 27],
            ['name' => 'Google Cloud', 'name_ar' => null, 'is_translatable' => false, 'sort_order' => 28],
            ['name' => 'Azure', 'name_ar' => null, 'is_translatable' => false, 'sort_order' => 29],
            ['name' => 'Linux', 'name_ar' => null, 'is_translatable' => false, 'sort_order' => 30],

            // Soft Skills (Translatable)
            ['name' => 'Communication', 'name_ar' => 'التواصل', 'is_translatable' => true, 'sort_order' => 31],
            ['name' => 'Leadership', 'name_ar' => 'القيادة', 'is_translatable' => true, 'sort_order' => 32],
            ['name' => 'Teamwork', 'name_ar' => 'العمل الجماعي', 'is_translatable' => true, 'sort_order' => 33],
            ['name' => 'Problem Solving', 'name_ar' => 'حل المشاكل', 'is_translatable' => true, 'sort_order' => 34],
            ['name' => 'Time Management', 'name_ar' => 'إدارة الوقت', 'is_translatable' => true, 'sort_order' => 35],
            ['name' => 'Project Management', 'name_ar' => 'إدارة المشاريع', 'is_translatable' => true, 'sort_order' => 36],
            ['name' => 'Customer Service', 'name_ar' => 'خدمة العملاء', 'is_translatable' => true, 'sort_order' => 37],
            ['name' => 'Sales', 'name_ar' => 'المبيعات', 'is_translatable' => true, 'sort_order' => 38],
            ['name' => 'Marketing', 'name_ar' => 'التسويق', 'is_translatable' => true, 'sort_order' => 39],
            ['name' => 'Human Resources', 'name_ar' => 'الموارد البشرية', 'is_translatable' => true, 'sort_order' => 40],
            ['name' => 'Accounting', 'name_ar' => 'المحاسبة', 'is_translatable' => true, 'sort_order' => 41],
            ['name' => 'Finance', 'name_ar' => 'المالية', 'is_translatable' => true, 'sort_order' => 42],
            ['name' => 'Data Analysis', 'name_ar' => 'تحليل البيانات', 'is_translatable' => true, 'sort_order' => 43],
            ['name' => 'Research', 'name_ar' => 'البحث', 'is_translatable' => true, 'sort_order' => 44],
            ['name' => 'Writing', 'name_ar' => 'الكتابة', 'is_translatable' => true, 'sort_order' => 45],
            ['name' => 'Translation', 'name_ar' => 'الترجمة', 'is_translatable' => true, 'sort_order' => 46],
            ['name' => 'Teaching', 'name_ar' => 'التدريس', 'is_translatable' => true, 'sort_order' => 47],
            ['name' => 'Training', 'name_ar' => 'التدريب', 'is_translatable' => true, 'sort_order' => 48],
            ['name' => 'Public Speaking', 'name_ar' => 'التحدث أمام الجمهور', 'is_translatable' => true, 'sort_order' => 49],
            ['name' => 'Negotiation', 'name_ar' => 'المفاوضات', 'is_translatable' => true, 'sort_order' => 50],
        ];

        foreach ($skills as $skill) {
            Skill::create($skill);
        }
    }
}