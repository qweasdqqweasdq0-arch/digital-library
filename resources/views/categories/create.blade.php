<x-app-layout>
    <div class="py-12" dir="rtl">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow-sm border">
                <h2 class="text-xl font-bold mb-4 text-right">إضافة تصنيف جديد</h2>
                <form action="{{ route('categories.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <input type="text" name="name" placeholder="اسم التصنيف (مثل: برمجة)" class="w-full border-gray-300 rounded-md text-right" required>
                    </div>
                    <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded">حفظ التصنيف</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>