<x-visitor-layout>
    <x-slot name="seo">
        {!! seo($SEOData) !!}
    </x-slot>
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <h1 class="text-3xl font-bold mb-8">{{ __('words.footer.legal.terms') }}</h1>

                <div class="space-y-6">
                    <section>
                        <h2 class="text-2xl font-semibold mb-4">1. {{ __('Acceptance of Terms') }}</h2>
                        <p class="mb-4">
                            {{ __('By accessing and using HADAF\'s services, you accept and agree to be bound by the terms and provision of this agreement.') }}
                        </p>
                    </section>

                    <section>
                        <h2 class="text-2xl font-semibold mb-4">2. {{ __('Use License') }}</h2>
                        <p class="mb-4">
                            {{ __('Permission is granted to temporarily download one copy of the materials on HADAF\'s website for personal, non-commercial transitory viewing only.') }}
                        </p>
                        <p class="mb-4">{{ __('This is the grant of a license, not a transfer of title, and under this license you may not:') }}</p>
                        <ul class="list-disc pl-6 space-y-2">
                            <li>{{ __('modify or copy the materials') }}</li>
                            <li>{{ __('use the materials for any commercial purpose or for any public display') }}</li>
                            <li>{{ __('attempt to reverse engineer any software contained on the website') }}</li>
                            <li>{{ __('remove any copyright or other proprietary notations from the materials') }}</li>
                        </ul>
                    </section>

                    <section>
                        <h2 class="text-2xl font-semibold mb-4">3. {{ __('User Accounts') }}</h2>
                        <p class="mb-4">
                            {{ __('When you create an account with us, you must provide information that is accurate, complete, and current at all times.') }}
                        </p>
                        <p class="mb-4">
                            {{ __('You are responsible for safeguarding the password and for all activities that occur under your account.') }}
                        </p>
                    </section>

                    <section>
                        <h2 class="text-2xl font-semibold mb-4">4. {{ __('Prohibited Uses') }}</h2>
                        <p class="mb-4">
                            {{ __('You may not use our service:') }}
                        </p>
                        <ul class="list-disc pl-6 space-y-2">
                            <li>{{ __('For any unlawful purpose or to solicit others to perform unlawful acts') }}</li>
                            <li>{{ __('To violate any international, federal, provincial, or state regulations, rules, laws, or local ordinances') }}</li>
                            <li>{{ __('To infringe upon or violate our intellectual property rights or the intellectual property rights of others') }}</li>
                            <li>{{ __('To harass, abuse, insult, harm, defame, slander, disparage, intimidate, or discriminate') }}</li>
                            <li>{{ __('To submit false or misleading information') }}</li>
                        </ul>
                    </section>

                    <section>
                        <h2 class="text-2xl font-semibold mb-4">5. {{ __('Service Availability') }}</h2>
                        <p class="mb-4">
                            {{ __('We reserve the right to withdraw or amend our service, and any service or material we provide, in our sole discretion without notice.') }}
                        </p>
                    </section>

                    <section>
                        <h2 class="text-2xl font-semibold mb-4">6. {{ __('Termination') }}</h2>
                        <p class="mb-4">
                            {{ __('We may terminate or suspend your account and bar access to the service immediately, without prior notice or liability, under our sole discretion, for any reason whatsoever and without limitation.') }}
                        </p>
                    </section>

                    <section>
                        <h2 class="text-2xl font-semibold mb-4">7. {{ __('Disclaimer') }}</h2>
                        <p class="mb-4">
                            {{ __('The information on this website is provided on an "as is" basis. To the fullest extent permitted by law, this Company excludes all representations, warranties, conditions and terms.') }}
                        </p>
                    </section>

                    <section>
                        <h2 class="text-2xl font-semibold mb-4">8. {{ __('Changes to Terms') }}</h2>
                        <p class="mb-4">
                            {{ __('We reserve the right to modify these terms at any time. We will notify users of any material changes to these terms.') }}
                        </p>
                    </section>

                    <section>
                        <h2 class="text-2xl font-semibold mb-4">9. {{ __('Contact Information') }}</h2>
                        <p class="mb-4">
                            {{ __('If you have any questions about these Terms of Service, please contact us at:') }}
                            <a href="mailto:legal@hadaf-hq.com" class="text-blue-600 dark:text-blue-400 hover:underline">legal@hadaf-hq.com</a>
                        </p>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-visitor-layout> 