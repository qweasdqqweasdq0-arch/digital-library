<section>
    <header>
        <h2 class="text-lg font-black text-gray-900 dark:text-white transition-colors">
            {{ __('معلومات الملف الشخصي') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">
            {{ __("قم بتحديث معلومات حسابك وبريدك الإلكتروني.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        {{-- حقل الاسم --}}
        <div>
            <x-input-label for="name" :value="__('الاسم')" class="dark:text-gray-100 font-bold" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full dark:bg-gray-900 dark:text-white dark:border-gray-600 focus:ring-2 focus:ring-indigo-500 font-medium" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        {{-- حقل البريد الإلكتروني --}}
        <div>
            <x-input-label for="email" :value="__('البريد الإلكتروني')" class="dark:text-gray-100 font-bold" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full dark:bg-gray-900 dark:text-white dark:border-gray-600 focus:ring-2 focus:ring-indigo-500 font-medium" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800 dark:text-gray-200 font-bold">
                        {{ __('بريدك الإلكتروني غير مفعل.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('انقر هنا لإعادة إرسال رابط التفعيل.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-bold text-sm text-green-600 dark:text-green-400">
                            {{ __('تم إرسال رابط تفعيل جديد إلى بريدك الإلكتروني.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button class="bg-indigo-600 dark:bg-indigo-500 hover:bg-indigo-700 dark:text-white font-black px-8 py-2 rounded-xl transition">
                {{ __('حفظ التغييرات') }}
            </x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-600 dark:text-green-400 font-bold"
                >{{ __('تم الحفظ بنجاح.') }}</p>
            @endif
        </div>
    </form>
</section>