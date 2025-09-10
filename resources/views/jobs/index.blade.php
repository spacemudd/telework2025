<x-visitor-layout>
    <x-slot name="seo">
        {!! seo($SEOData) !!}
    </x-slot>
    <div class="bg-gray-50">
        <div class="container mx-auto px-4 py-8">
            <div class="max-w-4xl mx-auto">

                <!-- Employment Type Breadcrumbs -->
                <div class="mb-4">
                    <nav class="flex flex-wrap gap-2" aria-label="Breadcrumb">
                        <a href="{{ route('jobs.index', ['locale' => app()->getLocale()]) }}" 
                           class="px-4 py-2 text-sm font-medium rounded-full border transition-colors duration-200 {{ !request('employment_type') ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50' }}">
                            {{ __('words.all') }}
                        </a>
                        @foreach($employmentTypes as $type)
                            <a href="{{ route('jobs.index', array_merge(request()->query(), ['employment_type' => $type, 'locale' => app()->getLocale()])) }}" 
                               class="px-4 py-2 text-sm font-medium rounded-full border transition-colors duration-200 {{ request('employment_type') == $type ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50' }}">
                                {{ __('words.' . $type) }}
                            </a>
                        @endforeach
                    </nav>
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
                            <!-- Sector -->
                            <div>
                                <label for="sector_id" class="block text-sm font-medium text-gray-700">{{ __('words.sector') }}</label>
                                <select id="sector_id" name="sector_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                    <option value="">{{ __('words.all') }}</option>
                                    @foreach($sectors as $sector)
                                        <option value="{{ $sector->id }}" {{ request('sector_id') == $sector->id ? 'selected' : '' }}>{{ $sector->localized_name }}</option>
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
