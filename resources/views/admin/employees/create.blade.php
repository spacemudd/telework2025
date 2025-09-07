@extends('layouts.admin')

@section('title', __('words.create_employee'))

@section('admin-content')
    <div class="grid grid-cols-12 p-5 justify-center">
        <div class="col-span-12 md:col-span-6 md:col-start-4">
            <div class="bg-white rounded">
                <div class="px-4 py-4 border-b">
                    <h2 class="text-lg font-semibold text-gray-800">{{ $company->name }} / {{ __('words.create_employee') }}</h2>
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

                <form method="POST" action="{{ route('admin.companies.employees.store', ['company' => $company->id]) }}" class="space-y-4 p-4 text-sm">
                    @csrf

                    <div>
                        <label class="block text-gray-700 mb-1 text-sm">{{ __('words.name') }}</label>
                        <input type="text" name="name" class="w-full border-gray-300 rounded-md shadow-sm py-2 text-sm" required>
                    </div>

                    <div>
                        <label class="block text-gray-700 mb-1 text-sm">{{ __('words.email') }}</label>
                        <input type="email" name="email" class="w-full border-gray-300 rounded-md shadow-sm py-2 text-sm" required>
                    </div>

                    <div>
                        <label class="block text-gray-700 mb-1 text-sm">{{ __('words.identity_number') }}</label>
                        <input type="text" name="identity_number" pattern="1\d{9}" title="يجب أن يتكون رقم الهوية من 10 أرقام ويبدأ بـ 1" class="w-full border-gray-300 rounded-md shadow-sm py-2 text-sm" required>
                        <div class="text-xs text-gray-500 mt-1">
                            <span id="identity-count">0</span> / 10
                        </div>
                        <script>
                            document.addEventListener('DOMContentLoaded', function () {
                                const identityInput = document.querySelector('[name="identity_number"]');
                                const identityCount = document.getElementById('identity-count');

                                identityInput.addEventListener('input', function () {
                                    identityCount.textContent = identityInput.value.length;
                                });
                            });
                        </script>
                    </div>

                    <div>
                        <label class="block text-gray-700 mb-1 text-sm">{{ __('words.phone') }}</label>
                        <input type="text" name="phone" pattern="966\d+" title="يجب أن يبدأ رقم الجوال بـ 966" class="w-full border-gray-300 rounded-md shadow-sm py-2 text-sm" required>
                    </div>

                    <div>
                        <label class="block text-gray-700 mb-1 text-sm">{{ __('words.position') }}</label>
                        <input type="text" name="position" list="position-options" class="w-full border-gray-300 rounded-md shadow-sm py-2 text-sm" required>
                        <datalist id="position-options">
                            <option value="خدمة عملاء">
                            <option value="مدخل بيانات">
                            <option value="مسؤول دعم فني">
                            <option value="مشرف عمليات">
                        </datalist>
                        <div class="mt-2 flex flex-wrap gap-2">
                            @php
                                $presetPositions = ['خدمة عملاء', 'مدخل بيانات', 'مسؤول دعم فني', 'مشرف عمليات', 'مساعد إداري'];
                            @endphp
                            @foreach($presetPositions as $pos)
                                <a href="#" onclick="event.preventDefault(); document.querySelector('[name=position]').value = '{{ $pos }}';"
                                   class="text-blue-600 text-xs underline hover:text-blue-800">
                                    {{ $pos }}
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <div class="bg-yellow-100 text-yellow-800 text-sm rounded-md p-4 my-4">
                        ** {{ __('words.create_employee_notice') }}
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition">
                            {{ __('words.save') }}
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
