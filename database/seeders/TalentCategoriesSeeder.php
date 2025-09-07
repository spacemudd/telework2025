<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TalentCategory;

class TalentCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name_ar' => 'المطورون',
                'name_en' => 'Developers',
                'description_ar' => 'مهندسو برمجيات متمرسون، ومبرمجون، ومعماريون لديهم خبرة في مئات التقنيات.',
                'description_en' => 'Seasoned software engineers, coders, and architects with expertise across hundreds of technologies.',
                'icon' => 'code',
                'color' => '#3B82F6',
                'sort_order' => 1
            ],
            [
                'name_ar' => 'المصممون',
                'name_en' => 'Designers',
                'description_ar' => 'خبراء في تصميم واجهات المستخدم وتجربة المستخدم والتصميم البصري والتفاعلي بالإضافة إلى مجموعة واسعة من الرسامين والمحركين وأكثر.',
                'description_en' => 'Expert UI, UX, Visual, and Interaction designers as well as a wide range of illustrators, animators, and more.',
                'icon' => 'design',
                'color' => '#10B981',
                'sort_order' => 2
            ],
            [
                'name_ar' => 'استشاريو الإدارة',
                'name_en' => 'Management Consultants',
                'description_ar' => 'خبراء مالية، واستراتيجيو أعمال، واستشاريو دمج واستحواذ، ونماذج مالية، وأكثر، مع خبرة تتراوح من أبحاث السوق إلى التخطيط والتحليل المالي.',
                'description_en' => 'Finance experts, business strategists, M&A consultants, financial modelers, and more, with expertise ranging from market research to FP&A.',
                'icon' => 'chart',
                'color' => '#F59E0B',
                'sort_order' => 3
            ],
            [
                'name_ar' => 'مديرو المشاريع',
                'name_en' => 'Project Managers',
                'description_ar' => 'مديرو مشاريع رقمية وتقنية، وأساتذة سكروم، وأكثر مع خبرة في العديد من أدوات وإطار عمل وأساليب إدارة المشاريع.',
                'description_en' => 'Digital and technical project managers, scrum masters, and more with expertise in numerous PM tools, frameworks, and styles.',
                'icon' => 'project',
                'color' => '#8B5CF6',
                'sort_order' => 4
            ],
            [
                'name_ar' => 'مديرو المنتجات',
                'name_en' => 'Product Managers',
                'description_ar' => 'مديرو منتجات رقمية، ومالكو منتجات سكروم مع خبرة في العديد من الصناعات مثل البنوك والرعاية الصحية والتجارة الإلكترونية وأكثر.',
                'description_en' => 'Digital product managers, scrum product owners with expertise in numerous industries like banking, healthcare, ecommerce, and more.',
                'icon' => 'product',
                'color' => '#EC4899',
                'sort_order' => 5
            ],
            [
                'name_ar' => 'خبراء التسويق',
                'name_en' => 'Marketing Experts',
                'description_ar' => 'خبراء في التسويق الرقمي، وتسويق النمو، وإنتاج المحتوى، وأبحاث السوق، وتنفيذ استراتيجية العلامة التجارية، والتسويق عبر وسائل التواصل الاجتماعي، وأكثر.',
                'description_en' => 'Experts in digital marketing, growth marketing, content creation, market research, brand strategy execution, social media marketing, and more.',
                'icon' => 'marketing',
                'color' => '#EF4444',
                'sort_order' => 6
            ]
        ];

        foreach ($categories as $category) {
            TalentCategory::create($category);
        }
    }
}
