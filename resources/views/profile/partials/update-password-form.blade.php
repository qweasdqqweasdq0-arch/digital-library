<section>
    <header>
        <h2 class="text-lg font-black text-gray-900 dark:text-white transition-colors">
            {{ __('تحديث كلمة المرور') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">
            {{ __('تأكد من استخدام كلمة مرور طويلة وعشوائية للحفاظ على أمان حسابك.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        {{-- كلمة المرور الحالية --}}
        <div>
            <x-input-label for="update_password_current_password" :value="__('كلمة المرور الحالية')" class="dark:text-gray-100 font-bold" />
            <x-text-input id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full dark:bg-gray-900 dark:text-white dark:border-gray-600 focus:ring-2 focus:ring-indigo-500 font-medium" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        {{-- كلمة المرور الجديدة --}}
        <div>
            <x-input-label for="update_password_password" :value="__('كلمة المرور الجديدة')" class="dark:text-gray-100 font-bold" />
            <x-text-input id="update_password_password" name="password" type="password" class="mt-1 block w-full dark:bg-gray-900 dark:text-white dark:border-gray-600 focus:ring-2 focus:ring-indigo-500 font-medium" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        {{-- تأكيد كلمة المرور --}}
        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('تأكيد كلمة المرور الجديدة')" class="dark:text-gray-100 font-bold" />
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full dark:bg-gray-900 dark:text-white dark:border-gray-600 focus:ring-2 focus:ring-indigo-500 font-medium" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button class="bg-indigo-600 dark:bg-indigo-500 hover:bg-indigo-700 dark:text-white font-black px-8 py-2 rounded-xl transition">
                {{ __('حفظ التغييرات') }}
            </x-primary-button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-600 dark:text-green-400 font-bold"
                >{{ __('تم التحديث بنجاح.') }}</p>
            @endif
        </div>
    </form>
</section>