@extends('layouts.admin')

@section('title', __('words.edit_employee'))

@section('admin-content')
    <div class="p-6 max-w-4xl mx-auto">

        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold">{{ __('words.edit_employee') }}</h2>
            <a href="{{ route('admin.companies.employees.show', [$company->id, $employee->id]) }}" 
               class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">
                {{ __('words.back') }}
            </a>
        </div>

        <form action="{{ route('admin.companies.employees.update', [$company->id, $employee->id]) }}" method="POST" class="bg-white p-6 rounded shadow">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block font-medium mb-2">{{ __('words.name') }}</label>
                    <input type="text" name="name" value="{{ old('name', $employee->name) }}" 
                           class="w-full border rounded p-2 @error('name') border-red-500 @enderror" required>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block font-medium mb-2">{{ __('words.email') }}</label>
                    <input type="email" name="email" value="{{ old('email', $employee->email) }}" 
                           class="w-full border rounded p-2 @error('email') border-red-500 @enderror" required>
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block font-medium mb-2">{{ __('words.identity_number') }}</label>
                    <input type="text" name="identity_number" value="{{ old('identity_number', $employee->identity_number) }}" 
                           class="w-full border rounded p-2 @error('identity_number') border-red-500 @enderror" required>
                    @error('identity_number')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block font-medium mb-2">{{ __('words.phone') }}</label>
                    <input type="text" name="phone" value="{{ old('phone', $employee->phone) }}" 
                           class="w-full border rounded p-2 @error('phone') border-red-500 @enderror">
                    @error('phone')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block font-medium mb-2">{{ __('words.position') }}</label>
                    <input type="text" name="position" value="{{ old('position', $employee->position) }}" 
                           class="w-full border rounded p-2 @error('position') border-red-500 @enderror">
                    @error('position')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6 flex gap-4">
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    {{ __('words.update_employee') }}
                </button>
                <a href="{{ route('admin.companies.employees.show', [$company->id, $employee->id]) }}" 
                   class="px-6 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">
                    {{ __('words.cancel') }}
                </a>
            </div>
        </form>

    </div>
@endsection 