<section class="space-y-6">
    <header>
        <h2 class="text-lg font-black text-red-600 dark:text-red-400 transition-colors">
            {{ __('حذف الحساب') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">
            {{ __('بمجرد حذف حسابك، سيتم حذف جميع موارده وبياناته نهائياً. قبل الحذف، يرجى تحميل أي بيانات ترغب في الاحتفاظ بها.') }}
        </p>
    </header>

    <x-danger-button
        x-data=""
        class="font-bold rounded-xl px-6 py-2"
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >{{ __('إغلاق الحساب نهائياً') }}</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6 bg-white dark:bg-gray-800 text-right" dir="rtl">
            @csrf
            @method('delete')

            <h2 class="text-lg font-black text-gray-900 dark:text-white">
                {{ __('هل أنت متأكد تماماً من رغبتك في حذف الحساب؟') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">
                {{ __('بمجرد حذف حسابك، سيتم حذف جميع البيانات نهائياً. يرجى إدخال كلمة المرور الخاصة بك لتأكيد طلب الحذف.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('كلمة المرور') }}" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-full md:w-3/4 dark:bg-gray-900 dark:text-white dark:border-gray-600 font-medium"
                    placeholder="{{ __('أدخل كلمة المرور للتأكيد') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-start gap-4 flex-row-reverse">
                <x-secondary-button x-on:click="$dispatch('close')" class="dark:bg-gray-700 dark:text-gray-200 font-bold border-none rounded-xl">
                    {{ __('إلغاء') }}
                </x-secondary-button>

                <x-danger-button class="font-black px-6 py-2 rounded-xl">
                    {{ __('تأكيد الحذف النهائي') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>