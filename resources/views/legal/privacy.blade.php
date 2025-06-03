<x-visitor-layout :seo="$seo">
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <h1 class="text-3xl font-bold mb-8">{{ __('words.footer.legal.privacy') }}</h1>

                <div class="space-y-6">
                    <section>
                        <h2 class="text-2xl font-semibold mb-4">1. {{ __('Introduction') }}</h2>
                        <p class="mb-4">
                            {{ __('At Telework2025, we take your privacy seriously. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you use our service.') }}
                        </p>
                    </section>

                    <section>
                        <h2 class="text-2xl font-semibold mb-4">2. {{ __('Information We Collect') }}</h2>
                        <ul class="list-disc pl-6 space-y-2">
                            <li>{{ __('Personal identification information (Name, email address, phone number, etc.)') }}</li>
                            <li>{{ __('Employment information') }}</li>
                            <li>{{ __('Usage data and analytics') }}</li>
                            <li>{{ __('Device and browser information') }}</li>
                        </ul>
                    </section>

                    <section>
                        <h2 class="text-2xl font-semibold mb-4">3. {{ __('How We Use Your Information') }}</h2>
                        <p class="mb-4">
                            {{ __('We use the collected information for various purposes including:') }}
                        </p>
                        <ul class="list-disc pl-6 space-y-2">
                            <li>{{ __('Providing and maintaining our service') }}</li>
                            <li>{{ __('Improving user experience') }}</li>
                            <li>{{ __('Analyzing usage patterns') }}</li>
                            <li>{{ __('Communicating with you') }}</li>
                        </ul>
                    </section>

                    <section>
                        <h2 class="text-2xl font-semibold mb-4">4. {{ __('Data Security') }}</h2>
                        <p class="mb-4">
                            {{ __('We implement appropriate technical and organizational security measures to protect your personal information. However, no method of transmission over the Internet is 100% secure.') }}
                        </p>
                    </section>

                    <section>
                        <h2 class="text-2xl font-semibold mb-4">5. {{ __('Your Rights') }}</h2>
                        <p class="mb-4">
                            {{ __('You have the right to:') }}
                        </p>
                        <ul class="list-disc pl-6 space-y-2">
                            <li>{{ __('Access your personal data') }}</li>
                            <li>{{ __('Correct inaccurate data') }}</li>
                            <li>{{ __('Request deletion of your data') }}</li>
                            <li>{{ __('Object to data processing') }}</li>
                        </ul>
                    </section>

                    <section>
                        <h2 class="text-2xl font-semibold mb-4">6. {{ __('Contact Us') }}</h2>
                        <p class="mb-4">
                            {{ __('If you have any questions about this Privacy Policy, please contact us at:') }}
                            <a href="mailto:privacy@telework2025.com" class="text-blue-600 dark:text-blue-400 hover:underline">privacy@telework2025.com</a>
                        </p>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-visitor-layout> 