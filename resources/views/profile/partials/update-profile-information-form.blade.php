<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and details.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send', ['locale' => app()->getLocale()]) }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update', ['locale' => app()->getLocale()]) }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <!-- Profile Image Upload -->
        <div class="flex flex-col items-center space-y-4">
            <div class="relative">
                @if($user->profile_image_url)
                    <img src="{{ $user->profile_image_url }}" alt="Profile Image" class="w-24 h-24 rounded-full object-cover border-4 border-gray-200">
                @else
                    <div class="w-24 h-24 rounded-full bg-gray-200 flex items-center justify-center border-4 border-gray-200">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                @endif
                <label for="profile_image" class="absolute bottom-0 right-0 bg-blue-600 text-white rounded-full p-2 cursor-pointer hover:bg-blue-700 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </label>
            </div>
            <input type="file" id="profile_image" name="profile_image" class="hidden" accept="image/*">
            <x-input-error class="mt-2" :messages="$errors->get('profile_image')" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <x-input-label for="first_name" :value="__('First Name')" />
                <x-text-input id="first_name" name="first_name" type="text" class="mt-1 block w-full" :value="old('first_name', $user->first_name)" required autofocus autocomplete="given-name" />
                <x-input-error class="mt-2" :messages="$errors->get('first_name')" />
            </div>

            <div>
                <x-input-label for="last_name" :value="__('Last Name')" />
                <x-text-input id="last_name" name="last_name" type="text" class="mt-1 block w-full" :value="old('last_name', $user->last_name)" required autocomplete="family-name" />
                <x-input-error class="mt-2" :messages="$errors->get('last_name')" />
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
                <x-input-error class="mt-2" :messages="$errors->get('email')" />

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div>
                        <p class="text-sm mt-2 text-gray-800">
                            {{ __('Your email address is unverified.') }}

                            <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                {{ __('Click here to re-send the verification email.') }}
                            </button>
                        </p>

                        @if (session('status') === 'verification-link-sent')
                            <p class="mt-2 font-medium text-sm text-green-600">
                                {{ __('A new verification link has been sent to your email address.') }}
                            </p>
                        @endif
                    </div>
                @endif
            </div>

            <div>
                <x-input-label for="phone" value="رقم الهاتف" />
                <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone', $user->employee->phone ?? '')" autocomplete="tel" />
                <x-input-error class="mt-2" :messages="$errors->get('phone')" />
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <x-input-label for="experience_level" value="مستوى الخبرة" />
                <select id="experience_level" name="experience_level" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                    <option value="">اختر مستوى الخبرة</option>
                    <option value="entry" {{ old('experience_level', $user->employee->experience_level ?? '') == 'entry' ? 'selected' : '' }}>مبتدئ (0-2 سنوات)</option>
                    <option value="mid_level" {{ old('experience_level', $user->employee->experience_level ?? '') == 'mid_level' ? 'selected' : '' }}>متوسط (3-5 سنوات)</option>
                    <option value="senior" {{ old('experience_level', $user->employee->experience_level ?? '') == 'senior' ? 'selected' : '' }}>متقدم (6-10 سنوات)</option>
                    <option value="expert" {{ old('experience_level', $user->employee->experience_level ?? '') == 'expert' ? 'selected' : '' }}>خبير (10+ سنوات)</option>
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('experience_level')" />
            </div>

            <div>
                <x-input-label for="preferred_work_type" value="نوع العمل المفضل" />
                <select id="preferred_work_type" name="preferred_work_type" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                    <option value="">اختر نوع العمل</option>
                    <option value="full_time" {{ old('preferred_work_type', $user->employee->preferred_work_type ?? '') == 'full_time' ? 'selected' : '' }}>دوام كامل</option>
                    <option value="part_time" {{ old('preferred_work_type', $user->employee->preferred_work_type ?? '') == 'part_time' ? 'selected' : '' }}>دوام جزئي</option>
                    <option value="contract" {{ old('preferred_work_type', $user->employee->preferred_work_type ?? '') == 'contract' ? 'selected' : '' }}>عقد</option>
                    <option value="freelance" {{ old('preferred_work_type', $user->employee->preferred_work_type ?? '') == 'freelance' ? 'selected' : '' }}>عمل حر</option>
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('preferred_work_type')" />
            </div>
        </div>

        <div>
            <x-input-label for="skills" value="المهارات" />
            <x-text-input id="skills" name="skills" type="text" class="mt-1 block w-full" :value="old('skills', $user->employee->skills ?? '')" placeholder="مثال: برمجة، تصميم، إدارة مشاريع (مفصولة بفواصل)" />
            <p class="mt-1 text-sm text-gray-500">أدخل مهاراتك مفصولة بفواصل</p>
            <x-input-error class="mt-2" :messages="$errors->get('skills')" />
        </div>

        <div>
            <x-input-label for="bio" value="نبذة شخصية" />
            <textarea id="bio" name="bio" rows="4" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="اكتب نبذة مختصرة عن نفسك وخبراتك المهنية...">{{ old('bio', $user->employee->bio ?? '') }}</textarea>
            <p class="mt-1 text-sm text-gray-500">حد أقصى 1000 حرف</p>
            <x-input-error class="mt-2" :messages="$errors->get('bio')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated' || session('success'))
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 3000)"
                    class="text-sm text-green-600"
                >{{ session('success') ?? __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>

<script>
document.getElementById('profile_image').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = document.querySelector('img[alt="Profile Image"]') || 
                       document.querySelector('.w-24.h-24.rounded-full');
            
            if (img && img.tagName === 'IMG') {
                img.src = e.target.result;
            } else {
                // Replace the placeholder div with an img element
                const placeholder = document.querySelector('.w-24.h-24.rounded-full.bg-gray-200');
                if (placeholder) {
                    const newImg = document.createElement('img');
                    newImg.src = e.target.result;
                    newImg.alt = 'Profile Image';
                    newImg.className = 'w-24 h-24 rounded-full object-cover border-4 border-gray-200';
                    placeholder.parentNode.replaceChild(newImg, placeholder);
                }
            }
        };
        reader.readAsDataURL(file);
    }
});
</script>