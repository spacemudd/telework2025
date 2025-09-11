@extends('layouts.admin')

@section('title', __('words.edit_company'))

@section('admin-content')
<div class="p-6 max-w-4xl mx-auto">
    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">{{ __('words.edit_company') }}: {{ $company->name }}</h1>
            <a href="{{ route('admin.companies.show', $company->id) }}" class="text-blue-600 hover:underline text-sm">
                &larr; {{ __('words.back_to_company') }}
            </a>
        </div>

        <!-- Company Properties Form -->
        <form method="POST" action="{{ route('admin.companies.update', $company->id) }}" class="space-y-4 mb-8">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 mb-2 text-sm font-medium">{{ __('words.name') }}</label>
                    <input type="text" name="name" value="{{ old('name', $company->name) }}" 
                           class="w-full border-gray-300 rounded-md shadow-sm py-2 text-sm" required>
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-gray-700 mb-2 text-sm font-medium">{{ __('words.email') }}</label>
                    <input type="email" name="email" value="{{ old('email', $company->email) }}" 
                           class="w-full border-gray-300 rounded-md shadow-sm py-2 text-sm" required>
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-gray-700 mb-2 text-sm font-medium">{{ __('words.address') }}</label>
                    <input type="text" name="address" value="{{ old('address', $company->address) }}" 
                           class="w-full border-gray-300 rounded-md shadow-sm py-2 text-sm" required>
                    @error('address')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-gray-700 mb-2 text-sm font-medium">{{ __('words.cr_number') }}</label>
                    <input type="text" name="cr_number" value="{{ old('cr_number', $company->cr_number) }}" 
                           class="w-full border-gray-300 rounded-md shadow-sm py-2 text-sm" required>
                    @error('cr_number')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-gray-700 mb-2 text-sm font-medium">{{ __('words.phone') }}</label>
                    <input type="text" name="phone" value="{{ old('phone', $company->phone) }}" 
                           class="w-full border-gray-300 rounded-md shadow-sm py-2 text-sm" required>
                    @error('phone')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded-md hover:bg-blue-700 transition">
                    {{ __('words.update_company') }}
                </button>
            </div>
        </form>

        <!-- Separator -->
        <hr class="my-8 border-gray-300">

        <!-- Team Management Section -->
        <div class="mt-8">
            <h2 class="text-xl font-semibold mb-6">{{ __('words.team_management') }}</h2>

            <!-- Current Team Members -->
            <div class="mb-6">
                <h3 class="text-lg font-medium mb-4">{{ __('words.current_team_members') }}</h3>
                
                @if($company->users->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm bg-white rounded-lg shadow">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="text-left py-2 px-4">{{ __('words.name') }}</th>
                                    <th class="text-left py-2 px-4">{{ __('words.email') }}</th>
                                    <th class="text-left py-2 px-4">{{ __('words.role') }}</th>
                                    <th class="text-left py-2 px-4">{{ __('words.primary') }}</th>
                                    <th class="text-left py-2 px-4">{{ __('words.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($company->users as $user)
                                    <tr class="border-b">
                                        <td class="py-2 px-4">{{ $user->name }}</td>
                                        <td class="py-2 px-4">{{ $user->email }}</td>
                                        <td class="py-2 px-4">
                                            <form method="POST" action="{{ route('admin.companies.users.role', $company->id) }}" class="inline">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="user_id" value="{{ $user->id }}">
                                                <select name="role" onchange="this.form.submit()" class="border rounded px-2 py-1 text-xs">
                                                    <option value="owner" {{ $user->pivot->role === 'owner' ? 'selected' : '' }}>{{ __('words.owner') }}</option>
                                                    <option value="admin" {{ $user->pivot->role === 'admin' ? 'selected' : '' }}>{{ __('words.admin') }}</option>
                                                    <option value="member" {{ $user->pivot->role === 'member' ? 'selected' : '' }}>{{ __('words.member') }}</option>
                                                </select>
                                            </form>
                                        </td>
                                        <td class="py-2 px-4">
                                            @if($user->pivot->is_primary)
                                                <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">{{ __('words.yes') }}</span>
                                            @else
                                                <span class="bg-gray-100 text-gray-800 text-xs px-2 py-1 rounded-full">{{ __('words.no') }}</span>
                                            @endif
                                        </td>
                                        <td class="py-2 px-4">
                                            @if($company->users()->where('role', 'owner')->count() > 1 || $user->pivot->role !== 'owner')
                                                <form method="POST" action="{{ route('admin.companies.users.detach', $company->id) }}" class="inline">
                                                    @csrf
                                                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                                                    <button type="submit" class="text-red-600 hover:underline text-xs" 
                                                            onclick="return confirm('{{ __('words.are_you_sure_remove_user') }}')">
                                                        {{ __('words.remove') }}
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-gray-400 text-xs">{{ __('words.cannot_remove') }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-gray-500 text-sm">{{ __('words.no_team_members') }}</p>
                @endif
            </div>

            <!-- Add New Team Member -->
            <div class="bg-gray-50 rounded-lg p-4">
                <h3 class="text-lg font-medium mb-4">{{ __('words.add_new_team_member') }}</h3>
                
                <form method="POST" action="{{ route('admin.companies.users.attach', $company->id) }}" class="flex gap-4 items-end">
                    @csrf
                    <div class="flex-1">
                        <label class="block text-gray-700 mb-2 text-sm font-medium">{{ __('words.enter_email_address') }}</label>
                        <input type="email" name="email" placeholder="user@example.com" class="w-full border-gray-300 rounded-md shadow-sm py-2 text-sm" required>
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 mb-2 text-sm font-medium">{{ __('words.role') }}</label>
                        <select name="role" class="border-gray-300 rounded-md shadow-sm py-2 text-sm" required>
                            <option value="member">{{ __('words.member') }}</option>
                            <option value="admin">{{ __('words.admin') }}</option>
                            <option value="owner">{{ __('words.owner') }}</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition">
                        {{ __('words.invite_user') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
