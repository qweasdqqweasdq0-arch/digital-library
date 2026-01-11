<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="text-right" dir="rtl">
        @csrf

        <div>
            <x-input-label for="email" :value="__('البريد الإلكتروني')" class="dark:text-gray-200 font-bold mb-1" />
            <x-text-input id="email" class="block mt-1 w-full dark:bg-gray-900 dark:text-white dark:border-gray-700 focus:ring-indigo-500" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="__('كلمة المرور')" class="dark:text-gray-200 font-bold mb-1" />

            <x-text-input id="password" class="block mt-1 w-full dark:bg-gray-900 dark:text-white dark:border-gray-700 focus:ring-indigo-500"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400 font-bold">{{ __('تذكرني') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4 gap-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 font-medium" href="{{ route('password.request') }}">
                    {{ __('نسيت كلمة المرور؟') }}
                </a>
            @endif

            <x-primary-button class="ms-3 bg-gray-800 dark:bg-blue-600 dark:hover:bg-blue-700 px-6 py-2 rounded-xl font-black">
                {{ __('دخول') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>