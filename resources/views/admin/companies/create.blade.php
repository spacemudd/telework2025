@extends('layouts.admin')

@section('title', __('words.create_company'))

@section('admin-content')
    <div class="grid grid-cols-12 p-5 justify-center">
        <div class="col-span-12 md:col-span-6 md:col-start-4">
            <div class="bg-white rounded">
                <div class="px-4 py-4 border-b">
                    <h2 class="text-lg font-semibold text-gray-800">{{ __('words.create_company') }}</h2>
                    @if ($errors->any())
                        <div class="bg-red-100 text-red-800 text-sm rounded-md p-4 m-4">
                            <ul class="list-disc pl-5 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
                <form method="POST" action="{{ route('admin.companies.store') }}" class="space-y-4 p-4 text-sm">
                    @csrf

                    <div class="mb-2">
                        <label class="block text-gray-700 mb-2 text-sm">{{ __('words.name') }}</label>
                        <input type="text" name="name" class="w-full border-gray-300 rounded-md shadow-sm py-2 text-sm" required>
                    </div>

                    <div class="mb-2">
                        <label class="block text-gray-700 mb-2 text-sm">{{ __('words.email') }}</label>
                        <input type="email" name="email" class="w-full border-gray-300 rounded-md shadow-sm py-2 text-sm" required>
                    </div>

                    <div class="mb-2">
                        <label class="block text-gray-700 mb-2 text-sm">{{ __('words.address') }}</label>
                        <input type="text" name="address" class="w-full border-gray-300 rounded-md shadow-sm py-2 text-sm" required>
                    </div>

                    <div class="mb-2">
                        <label class="block text-gray-700 mb-2 text-sm">{{ __('words.cr_number') }}</label>
                        <input type="text" name="cr_number" class="w-full border-gray-300 rounded-md shadow-sm py-2 text-sm" required>
                    </div>

                    <div class="mb-2">
                        <label class="block text-gray-700 mb-2 text-sm">{{ __('words.phone') }}</label>
                        <input type="text" name="phone" class="w-full border-gray-300 rounded-md shadow-sm py-2 text-sm" required>
                    </div>

                    <div class="bg-yellow-100 text-yellow-800 text-sm rounded-md p-4 my-4">
                        ** {{ __('words.create_company_notice') }}
                    </div>

                    <div class="flex justify-end">

                        <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded-md hover:bg-blue-700 transition">
                            {{ __('words.save') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
