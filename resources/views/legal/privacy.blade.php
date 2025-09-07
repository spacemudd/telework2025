<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('words.footer.legal.privacy') }} - {{ config('app.name') }}</title>
    <meta name="description" content="{{ __('words.footer.legal.privacy') }}">
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
                    <h1 class="text-4xl font-bold text-gray-900 mb-8 text-right">{{ __('words.footer.legal.privacy') }}</h1>
                
                    <div class="text-gray-600 leading-relaxed space-y-6 text-right">
                        <p class="text-lg">
                            آخر تحديث: {{ date('Y-m-d') }}
                        </p>

                        <section>
                            <h2 class="text-2xl font-semibold text-gray-900 mb-4">1. مقدمة</h2>
                        <p>
                            نحن في شركة هدف للخدمات البشرية نحترم خصوصيتك ونلتزم بحماية معلوماتك الشخصية. 
                            تشرح هذه السياسة كيفية جمعنا واستخدامنا وحماية معلوماتك الشخصية عند استخدام موقعنا الإلكتروني وخدماتنا.
                        </p>
                    </section>

                        <section>
                            <h2 class="text-2xl font-semibold text-gray-900 mb-4">2. المعلومات التي نجمعها</h2>
                        <p>نجمع أنواع مختلفة من المعلومات، بما في ذلك:</p>
                        <ul class="list-disc list-inside space-y-2">
                            <li>المعلومات الشخصية (الاسم، البريد الإلكتروني، رقم الهاتف)</li>
                            <li>معلومات السيرة الذاتية والمهنية</li>
                            <li>معلومات الشركة (لأصحاب العمل)</li>
                            <li>معلومات الاستخدام والتفضيلات</li>
                        </ul>
                    </section>

                        <section>
                            <h2 class="text-2xl font-semibold text-gray-900 mb-4">3. كيفية استخدام المعلومات</h2>
                        <p>نستخدم معلوماتك الشخصية لـ:</p>
                        <ul class="list-disc list-inside space-y-2">
                            <li>توفير خدمات التوظيف والبحث عن الوظائف</li>
                            <li>تطابق المرشحين مع الفرص الوظيفية المناسبة</li>
                            <li>تحسين خدماتنا وتجربة المستخدم</li>
                            <li>التواصل معك بشأن الخدمات ذات الصلة</li>
                        </ul>
                    </section>

                        <section>
                            <h2 class="text-2xl font-semibold text-gray-900 mb-4">4. حماية المعلومات</h2>
                            <p>
                                نستخدم تدابير أمنية متقدمة لحماية معلوماتك الشخصية من الوصول غير المصرح به أو التعديل أو الكشف أو التدمير.
                            </p>
                        </section>

                        <section>
                            <h2 class="text-2xl font-semibold text-gray-900 mb-4">5. مشاركة المعلومات</h2>
                            <p>
                                لا نبيع أو نؤجر معلوماتك الشخصية لأطراف ثالثة. قد نشارك معلوماتك فقط في الحالات التالية:
                            </p>
                            <ul class="list-disc list-inside space-y-2">
                                <li>مع أصحاب العمل المحتملين (بموافقتك)</li>
                                <li>مع مقدمي الخدمات الذين يساعدوننا في تشغيل موقعنا</li>
                                <li>عندما يتطلب القانون ذلك</li>
                            </ul>
                        </section>

                        <section>
                            <h2 class="text-2xl font-semibold text-gray-900 mb-4">6. حقوقك</h2>
                            <p>لديك الحق في:</p>
                            <ul class="list-disc list-inside space-y-2">
                                <li>الوصول إلى معلوماتك الشخصية</li>
                                <li>تصحيح المعلومات غير الدقيقة</li>
                                <li>حذف معلوماتك الشخصية</li>
                                <li>سحب الموافقة في أي وقت</li>
                            </ul>
                        </section>

                        <section>
                            <h2 class="text-2xl font-semibold text-gray-900 mb-4">7. الاتصال بنا</h2>
                            <p>
                                إذا كان لديك أي أسئلة حول سياسة الخصوصية هذه، يرجى الاتصال بنا على:
                            </p>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p><strong>البريد الإلكتروني:</strong> privacy@hadaf.com</p>
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