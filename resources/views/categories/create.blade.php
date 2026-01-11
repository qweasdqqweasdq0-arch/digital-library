<x-app-layout>
    <div class="py-12" dir="rtl">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">
            
            {{-- زر العودة --}}
            <div class="mb-6 flex justify-start">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 px-4 py-2 rounded-xl text-gray-600 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 transition shadow-sm font-bold text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span>العودة للمكتبة</span>
                </a>
            </div>

            <div class="bg-white dark:bg-gray-800 p-8 rounded-[2rem] shadow-xl border border-gray-100 dark:border-gray-700 text-right transition-colors duration-300">
                <div class="mb-6">
                    <h2 class="text-2xl font-black text-gray-800 dark:text-white">إضافة تصنيف جديد 📂</h2>
                    <p class="text-gray-500 dark:text-gray-400 text-xs mt-1">قم بإنشاء قسم جديد لتنظيم الكتب</p>
                </div>

                <form action="{{ route('categories.store') }}" method="POST">
                    @csrf
                    <div class="mb-6">
                        <label class="block mb-2 font-bold text-gray-700 dark:text-gray-300 text-sm">اسم التصنيف</label>
                        <input type="text" name="name" placeholder="مثلاً: روايات، برمجة، تاريخ..." 
                               class="w-full border-gray-200 dark:border-gray-600 dark:bg-gray-900 dark:text-white rounded-xl py-3 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-right font-medium" 
                               required>
                    </div>

                    <div class="flex flex-col gap-3">
                        <button type="submit" class="w-full bg-indigo-600 dark:bg-indigo-500 text-white py-3 rounded-xl font-black shadow-lg shadow-indigo-100 dark:shadow-none hover:bg-indigo-700 dark:hover:bg-indigo-600 transition">
                            حفظ القسم الجديد
                        </button>
                        <a href="{{ route('dashboard') }}" class="text-center text-gray-400 dark:text-gray-500 text-xs font-bold hover:text-gray-600 dark:hover:text-gray-300 transition mt-2">
                            إلغاء والعودة
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>