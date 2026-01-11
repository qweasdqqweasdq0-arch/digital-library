<x-app-layout>
    <div class="py-12" dir="rtl">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 p-10 rounded-[2.5rem] shadow-xl border border-gray-100 dark:border-gray-700 text-right">
                <div class="mb-8 border-b border-gray-50 dark:border-gray-700 pb-6">
                    <h2 class="text-3xl font-black text-gray-800 dark:text-white">إضافة كتاب جديد 📚</h2>
                    <p class="text-gray-400 mt-2 text-sm font-medium">املأ البيانات أدناه لرفع ملف الكتاب إلى المكتبة</p>
                </div>
                
                <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    <div>
    <label class="block mb-2 font-black text-gray-700 dark:text-gray-300 text-sm">عنوان الكتاب</label>
    <input type="text" name="title" class="w-full border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 dark:text-white rounded-2xl py-4 shadow-inner focus:ring-2 focus:ring-indigo-500 text-right font-medium" required>
</div>

<div>
    <label class="block mb-2 font-black text-gray-700 dark:text-gray-300 text-sm">اسم المؤلف</label>
    <input type="text" name="author" placeholder="أدخل اسم الكاتب أو المؤلف..." class="w-full border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 dark:text-white rounded-2xl py-4 shadow-inner focus:ring-2 focus:ring-indigo-500 text-right font-medium" required>
</div>

                    <div>
                        <label class="block mb-2 font-black text-gray-700 dark:text-gray-300 text-sm">تصنيف الكتاب</label>
                        <select name="category_id" class="w-full border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 dark:text-white rounded-2xl py-4 shadow-inner focus:ring-2 focus:ring-indigo-500 text-right font-bold" required>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <label class="block mb-2 font-black text-gray-700 dark:text-gray-300 text-sm">وصف مختصر</label>
                        <textarea name="description" rows="4" class="w-full border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 dark:text-white rounded-2xl py-4 shadow-inner focus:ring-2 focus:ring-indigo-500 text-right font-medium" required></textarea>
                    </div>

                    <div>
                        <label class="block mb-2 font-black text-gray-700 dark:text-gray-300 text-sm">ملف الكتاب الرقمي (PDF)</label>
                        <div class="relative border-2 border-dashed border-gray-100 dark:border-gray-600 rounded-[1.5rem] p-8 hover:bg-indigo-50 dark:hover:bg-gray-700 transition text-center group">
                            <input type="file" name="file" accept=".pdf" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" required>
                            <div class="text-gray-400 group-hover:text-indigo-600 transition">
                                <span class="text-4xl block mb-2">📄</span>
                                <p class="text-xs font-black uppercase">اضغط لرفع ملف PDF</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-6 pt-8 border-t border-gray-50 dark:border-gray-700">
                        <button type="submit" class="bg-indigo-600 text-white px-12 py-4 rounded-2xl font-black shadow-lg hover:bg-indigo-700 transition"> نشر الكتاب الآن </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>