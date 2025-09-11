@php
    $user = auth()->user();
    $companies = $user->companies()->orderBy('name')->get();
    $currentCompany = session('selected_company_id') ? 
        $companies->firstWhere('id', session('selected_company_id')) : 
        $user->primaryCompany;
    
    // If no current company, use the first available one
    if (!$currentCompany && $companies->count() > 0) {
        $currentCompany = $companies->first();
    }
@endphp

@if($companies->count() > 1)
    <div class="relative inline-block text-left">
        <form method="POST" action="{{ route('company.switch') }}" class="inline">
            @csrf
            <select name="company_id" onchange="this.form.submit()" 
                    class="bg-white border border-gray-300 rounded-md px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                @foreach($companies as $company)
                    <option value="{{ $company->id }}" 
                            {{ $currentCompany && $currentCompany->id === $company->id ? 'selected' : '' }}>
                        {{ $company->name }} ({{ __('words.' . $company->pivot->role) }})
                    </option>
                @endforeach
            </select>
        </form>
    </div>
@endif
