<x-visitor-layout>
    <x-slot name="seo">
        {!! seo($SEOData) !!}
    </x-slot>
    <div class="bg-gray-50">
        <div class="container mx-auto px-4 py-8">
            <div class="max-w-5xl mx-auto">
                <div class="text-center mb-12">
                    <h1 class="text-4xl font-bold text-gray-800 mb-4">{{ __('words.browse_jobs') }}</h1>
                    <p class="text-lg text-gray-600">
                        تصفح تفاصيل الوظيفة، والوصف الوظيفي، وموقع الوظيفة. أنشئ سيرتك الذاتية وقدّم عليها الآن
                    </p>
                </div>

                <!-- Filters -->
                <div class="bg-white p-6 rounded-xl shadow-lg mb-8">
                    <form action="{{ route('jobs.index', ['locale' => app()->getLocale()]) }}" method="GET">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                            <!-- Location -->
                            <div>
                                <label for="location" class="block text-sm font-medium text-gray-700">{{ __('words.city') }}</label>
                                <select id="location" name="location" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                    <option value="">{{ __('words.all') }}</option>
                                    @foreach($locations as $location)
                                        <option value="{{ $location }}" {{ request('location') == $location ? 'selected' : '' }}>{{ $location }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- Job Category -->
                            <div>
                                <label for="job_category_id" class="block text-sm font-medium text-gray-700">{{ __('words.job_category') }}</label>
                                <select id="job_category_id" name="job_category_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                    <option value="">{{ __('words.all') }}</option>
                                    @foreach($jobCategories as $category)
                                        <option value="{{ $category->id }}" {{ request('job_category_id') == $category->id ? 'selected' : '' }}>{{ $category->localized_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- Employment Type -->
                            <div>
                                <label for="employment_type" class="block text-sm font-medium text-gray-700">{{ __('words.employment_type') }}</label>
                                <select id="employment_type" name="employment_type" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                    <option value="">{{ __('words.all') }}</option>
                                    @foreach($employmentTypes as $type)
                                        <option value="{{ $type }}" {{ request('employment_type') == $type ? 'selected' : '' }}>{{ __('words.' . $type) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- Submit Button -->
                            <div class="md:col-span-1">
                                <button type="submit" class="w-full text-white px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 transition ease-in-out duration-150" 
                                        style="background-color: #012d48; --tw-ring-color: #012d48;"
                                        onmouseover="this.style.backgroundColor='#023a5c'" 
                                        onmouseout="this.style.backgroundColor='#012d48'">
                                    {{ __('words.filter') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>


                @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('info'))
                    <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 mb-6 rounded-md">
                        {{ session('info') }}
                    </div>
                @endif

                <x-job-listings 
                    :jobPostings="$jobPostings" 
                    :showLoadMore="false"
                    :title="__('words.browse_jobs')"
                    :subtitle="'تصفح تفاصيل الوظيفة، والوصف الوظيفي، وموقع الوظيفة. أنشئ سيرتك الذاتية وقدّم عليها الآن'"
                />
            </div>
        </div>
    </div>
</x-visitor-layout>
