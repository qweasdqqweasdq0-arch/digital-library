
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center flex-row-reverse">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('نظام التقارير والإحصائيات التحليلية') }}
            </h2>
            <a href="{{ route('dashboard') }}" class="bg-gray-800 text-white px-4 py-2 rounded-lg text-sm hover:bg-black transition">
                العودة للوحة التحكم
            </a>
        </div>
    </x-slot>

    <div class="py-12" dir="rtl">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- الكروت الإحصائية الرئيسية --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10 text-right">
                
                <div class="bg-white p-6 rounded-2xl shadow-sm border-r-8 border-blue-600">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-3xl">📚</span>
                        <div class="text-gray-500 text-sm font-bold">إجمالي الكتب</div>
                    </div>
                    <div class="text-4xl font-black text-gray-900">{{ $stats['total_books'] ?? 0 }}</div>
                    <p class="text-xs text-blue-600 mt-2 font-bold">محتوى المكتبة الكلي</p>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border-r-8 border-green-600">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-3xl">👥</span>
                        <div class="text-gray-500 text-sm font-bold">المستخدمين</div>
                    </div>
                    <div class="text-4xl font-black text-gray-900">{{ $stats['total_users'] ?? 0 }}</div>
                    <p class="text-xs text-green-600 mt-2 font-bold">قراء مسجلون</p>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border-r-8 border-purple-600">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-3xl">📂</span>
                        <div class="text-gray-500 text-sm font-bold">التصنيفات</div>
                    </div>
                    <div class="text-4xl font-black text-gray-900">{{ $stats['categories_count'] ?? 0 }}</div>
                    <p class="text-xs text-purple-600 mt-2 font-bold">أقسام متنوعة</p>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border-r-8 border-red-600">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-3xl">❤️</span>
                        <div class="text-gray-500 text-sm font-bold">المفضلة</div>
                    </div>
                    <div class="text-4xl font-black text-gray-900">{{ $stats['total_favorites'] ?? 0 }}</div>
                    <p class="text-xs text-red-600 mt-2 font-bold">إجمالي الإعجابات</p>
                </div>

            </div>

            {{-- جدول تفصيلي للكتب المرفوعة --}}
            <div class="bg-white shadow-sm rounded-2xl overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center flex-row-reverse">
                    <h3 class="text-lg font-bold text-gray-800 italic underline decoration-blue-500 decoration-4">قائمة بيانات الكتب التفصيلية</h3>
                    <button onclick="window.print()" class="text-xs bg-blue-50 text-blue-700 px-3 py-1 rounded hover:bg-blue-100 font-bold">
                        طباعة التقرير PDF
                    </button>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-right border-collapse">
                        <thead>
                            <tr class="bg-gray-50 text-gray-600 text-sm">


<th class="p-4 border-b">اسم الكتاب</th>
                                <th class="p-4 border-b">التصنيف</th>
                                <th class="p-4 border-b text-center">تاريخ النشر</th>
                                <th class="p-4 border-b text-center">الحالة</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            @forelse($books ?? [] as $book)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="p-4 border-b font-medium">{{ $book->title }}</td>
                                    <td class="p-4 border-b">
                                        <span class="bg-gray-100 px-2 py-1 rounded text-xs">{{ $book->category->name ?? 'غير محدد' }}</span>
                                    </td>
                                    <td class="p-4 border-b text-center text-sm font-mono">{{ $book->created_at->format('Y/m/d') }}</td>
                                    <td class="p-4 border-b text-center">
                                        <span class="text-green-600 text-xs font-bold bg-green-50 px-2 py-1 rounded-full">نشط</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="p-10 text-center text-gray-400">لا توجد بيانات كتب لعرضها في التقرير.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- تذييل التقرير --}}
            <div class="mt-6 text-center text-gray-400 text-xs">
                تم استخراج هذا التقرير تلقائياً بتاريخ: {{ now()->format('Y-m-d H:i') }}
            </div>
        </div>
    </div>
</x-app-layout>