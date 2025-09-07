<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('words.footer.legal.terms') }} - {{ config('app.name') }}</title>
    <meta name="description" content="{{ __('words.footer.legal.terms') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Zain:ital,wght@0,200;0,300;0,400;0,700;0,800;0,900;1,300;1,400&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/css/scroll-animations.css', 'resources/js/app.js', 'resources/js/scroll-animations.js'])
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body { direction: rtl; text-align: right; }
        .prose { text-align: right; }
        .prose h1, .prose h2, .prose h3, .prose h4, .prose h5, .prose h6 { text-align: right; }
        .prose p { text-align: right; }
        .prose ul { text-align: right; }
        .prose li { text-align: right; }
        .prose ol { text-align: right; direction: rtl; }
        .prose ol li { text-align: right; direction: rtl; }
        .prose ol li::marker { content: counter(list-item, arabic-indic) "."; }
        .prose ol { counter-reset: list-item; }
        .prose ol li { counter-increment: list-item; }
    </style>
</head>
<body class="font-sans text-gray-900 antialiased bg-gray-100" dir="rtl">
    <div class="min-h-screen">
        <div class="bg-white py-20">
            <div class="container mx-auto px-4 max-w-4xl">
                <div class="prose prose-lg max-w-none">
                    <h1 class="text-4xl font-bold text-gray-900 mb-8 text-right">{{ __('words.footer.legal.terms') }}</h1>
                
                    <div class="text-gray-600 leading-relaxed space-y-6 text-right">
                        <p class="text-lg">
                            آخر تحديث: {{ date('Y-m-d') }}
                        </p>

                        <section>
                            <h2 class="text-2xl font-semibold text-gray-900 mb-4">1. قبول الشروط</h2>
                        <p>
                            بوصولك إلى موقعنا الإلكتروني واستخدامك لخدماتنا، فإنك توافق على الالتزام بهذه الشروط والأحكام. 
                            إذا كنت لا توافق على أي جزء من هذه الشروط، فيرجى عدم استخدام موقعنا أو خدماتنا.
                        </p>
                    </section>

                        <section>
                            <h2 class="text-2xl font-semibold text-gray-900 mb-4">2. وصف الخدمة</h2>
                            <p>
                                هدف للخدمات البشرية هي منصة توظيف تربط بين أصحاب العمل والباحثين عن العمل في المملكة العربية السعودية. 
                                نقدم خدمات الوساطة في التوظيف والبحث عن الوظائف المناسبة.
                            </p>
                        </section>

                        <section>
                            <h2 class="text-2xl font-semibold text-gray-900 mb-4">3. مسؤوليات المستخدم</h2>
                            <p>عند استخدام خدماتنا، يتعهد المستخدم بـ:</p>
                            <ul class="list-disc list-inside space-y-2">
                                <li>تقديم معلومات دقيقة وصحيحة</li>
                                <li>الحفاظ على سرية حساب المستخدم</li>
                                <li>عدم استخدام الخدمة لأغراض غير قانونية</li>
                                <li>احترام حقوق الملكية الفكرية</li>
                                <li>عدم إرسال محتوى مسيء أو غير مناسب</li>
                            </ul>
                        </section>

                        <section>
                            <h2 class="text-2xl font-semibold text-gray-900 mb-4">4. حقوق الملكية الفكرية</h2>
                            <p>
                                جميع المحتويات الموجودة على موقعنا، بما في ذلك النصوص والرسومات والشعارات والصور، 
                                محمية بحقوق الطبع والنشر ومملوكة لشركة هدف أو أطراف ثالثة مرخصة.
                            </p>
                        </section>

                        <section>
                            <h2 class="text-2xl font-semibold text-gray-900 mb-4">5. الخدمات المقدمة</h2>
                            <p>نقدم الخدمات التالية:</p>
                            <ul class="list-disc list-inside space-y-2">
                                <li>منصة للبحث عن الوظائف</li>
                                <li>خدمات الوساطة في التوظيف</li>
                                <li>أدوات إدارة المواهب للشركات</li>
                                <li>خدمات الاستشارة المهنية</li>
                            </ul>
                        </section>

                        <section>
                            <h2 class="text-2xl font-semibold text-gray-900 mb-4">6. الدفع والرسوم</h2>
                            <p>
                                قد تكون بعض الخدمات مدفوعة. الرسوم والمدفوعات تحكمها الشروط المحددة في صفحة التسعير. 
                                نحتفظ بالحق في تغيير الرسوم مع إشعار مسبق.
                            </p>
                        </section>

                        <section>
                            <h2 class="text-2xl font-semibold text-gray-900 mb-4">7. إلغاء الخدمة</h2>
                            <p>
                                نحتفظ بالحق في تعليق أو إلغاء حساب أي مستخدم ينتهك هذه الشروط أو يستخدم الخدمة بشكل غير مناسب.
                            </p>
                        </section>

                        <section>
                            <h2 class="text-2xl font-semibold text-gray-900 mb-4">8. إخلاء المسؤولية</h2>
                            <p>
                                نحن لا نضمن توفر الخدمة بشكل مستمر أو خالي من الأخطاء. 
                                استخدامك للخدمة على مسؤوليتك الخاصة.
                            </p>
                        </section>

                        <section>
                            <h2 class="text-2xl font-semibold text-gray-900 mb-4">9. القانون الحاكم</h2>
                            <p>
                                تحكم هذه الشروط وتفسر وفقاً لقوانين المملكة العربية السعودية. 
                                أي نزاعات تخضع لاختصاص المحاكم السعودية.
                            </p>
                        </section>

                        <section>
                            <h2 class="text-2xl font-semibold text-gray-900 mb-4">10. التعديلات</h2>
                            <p>
                                نحتفظ بالحق في تعديل هذه الشروط في أي وقت. 
                                سيتم إشعار المستخدمين بأي تغييرات مهمة عبر الموقع أو البريد الإلكتروني.
                            </p>
                        </section>

                        <section>
                            <h2 class="text-2xl font-semibold text-gray-900 mb-4">11. الاتصال بنا</h2>
                            <p>
                                إذا كان لديك أي أسئلة حول هذه الشروط والأحكام، يرجى الاتصال بنا على:
                            </p>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p><strong>البريد الإلكتروني:</strong> legal@hadaf.com</p>
                            </div>
                            <div class="mt-8 text-center">
                                <a href="/ar" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 transition duration-150 ease-in-out">
                                    العودة إلى الصفحة الرئيسية
                                </a>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html> 