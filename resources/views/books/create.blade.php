<x-app-layout>
    <div class="py-12" dir="rtl">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow-sm border text-right">
                <h2 class="text-2xl font-bold mb-6">إضافة كتاب جديد</h2>
                
                <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label class="block mb-2 font-bold">عنوان الكتاب</label>
                        <input type="text" name="title" class="w-full border-gray-300 rounded-md shadow-sm text-right" required>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 font-bold">تصنيف الكتاب</label>
                        <select name="category_id" class="w-full border-gray-300 rounded-md shadow-sm text-right" required>
                            <option value="">اختر التصنيف...</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block mb-2 font-bold">وصف الكتاب</label>
                        <textarea name="description" rows="4" class="w-full border-gray-300 rounded-md shadow-sm text-right" required></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 font-bold">ملف الكتاب (PDF أو EPUB)</label>
                        <input type="file" name="file" class="w-full border-gray-300 rounded-md shadow-sm" required>
                    </div>

                    <div class="flex justify-end gap-2">
                        <a href="{{ route('dashboard') }}" class="bg-gray-500 text-white px-6 py-2 rounded shadow">إلغاء</a>
                        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded shadow hover:bg-blue-700">حفظ الكتاب</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>