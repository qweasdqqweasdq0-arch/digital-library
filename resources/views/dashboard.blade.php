
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-right">
            {{ __('لوحة التحكم الرئيسية') }}
        </h2>
    </x-slot>

    <div class="py-12" dir="rtl">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 text-right">
            
            {{-- 1. أزرار التحكم الخاصة بالأدمن فقط --}}
            @role('admin')
            <div class="mb-8 flex flex-wrap gap-3 justify-start items-center">
                <a href="{{ route('admin.reports') }}" class="bg-purple-600 text-white px-5 py-2 rounded-xl font-bold shadow hover:bg-purple-700 transition">📊 التقارير</a>
                <a href="{{ route('categories.create') }}" class="bg-gray-800 text-white px-5 py-2 rounded-xl font-bold shadow hover:bg-black transition">📂 إضافة تصنيف</a>
                <a href="{{ route('books.create') }}" class="bg-blue-600 text-white px-5 py-2 rounded-xl font-bold shadow hover:bg-blue-700 transition">➕ إضافة كتاب</a>
            </div>
            @endrole

            {{-- 2. شريط البحث والفلترة المتقدمة --}}
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 mb-8">
                <form action="{{ route('dashboard') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-end">
                    
                    <div class="flex-1 w-full text-right">
                        <label class="block text-sm font-bold text-gray-700 mb-2">ابحث عن كتاب</label>
                        <input type="text" name="search" value="{{ request('search') }}" 
                               placeholder="اكتب عنوان الكتاب أو اسم المؤلف..." 
                               class="w-full border-gray-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                    </div>

                    <div class="w-full md:w-64 text-right">
                        <label class="block text-sm font-bold text-gray-700 mb-2">التصنيف</label>
                        <select name="category_id" class="w-full border-gray-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                            <option value="">كل الأقسام</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex gap-2 w-full md:w-auto">
                        <button type="submit" class="bg-blue-600 text-white px-6 py-2.5 rounded-xl font-bold hover:bg-blue-700 transition shadow-md flex-1">
                            بحث
                        </button>
                        @if(request()->has('search') || request()->has('category_id'))
                            <a href="{{ route('dashboard') }}" class="bg-gray-100 text-gray-600 px-6 py-2.5 rounded-xl font-bold hover:bg-gray-200 transition text-center flex-1">
                                إلغاء
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            {{-- 3. شبكة عرض الكتب --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($books as $book)
                    <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 relative transition hover:shadow-md">
                        
                        {{-- زر الحذف للأدمن فقط --}}
                        @role('admin')
                        <form action="{{ route('books.destroy', $book->id) }}" method="POST" class="absolute top-2 left-2">


@csrf @method('DELETE')
                            <button type="submit" onclick="return confirm('هل أنت متأكد من حذف هذا الكتاب؟')" class="text-red-500 text-xs bg-red-50 p-1 rounded hover:bg-red-100">حذف</button>
                        </form>
                        @endrole

                        {{-- التصنيف وزر المفضلة --}}
                        <div class="flex justify-between items-start mb-4 flex-row-reverse">
                            <span class="text-xs font-bold bg-blue-50 text-blue-600 px-3 py-1 rounded-full">
                                {{ $book->category->name ?? 'عام' }}
                            </span>
                            <form action="{{ route('books.favorite', $book->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-xl hover:scale-110 transition">
                                    {{ auth()->user()->favorites()->where('book_id', $book->id)->exists() ? '❤️' : '🤍' }}
                                </button>
                            </form>
                        </div>

                        <h3 class="font-bold text-lg mb-2 text-gray-800">{{ $book->title }}</h3>
                        <p class="text-gray-500 text-sm mb-4 line-clamp-2">{{ Str::limit($book->description, 80) }}</p>

                        {{-- نظام التقييم (يعرض المتوسط العام) --}}
                        <div class="flex items-center gap-1 mb-6" dir="ltr">
                            <form action="{{ route('books.rate', $book->id) }}" method="POST" class="flex flex-row-reverse items-center">
                                @csrf
                                @php
                                    // جلب المتوسط وتقريبه لعرض النجوم الملونة
                                    $avgRating = round($book->ratings()->avg('rating') ?? 0);
                                @endphp
                                @for ($i = 5; $i >= 1; $i--)
                                    <input type="radio" id="star{{ $i }}-{{ $book->id }}" name="rating" value="{{ $i }}" class="hidden" onchange="this.form.submit()">
                                    <label for="star{{ $i }}-{{ $book->id }}" 
                                           class="cursor-pointer text-2xl transition {{ $avgRating >= $i ? 'text-yellow-400' : 'text-gray-300' }} hover:text-yellow-500">
                                        ★
                                    </label>
                                @endfor
                            </form>
                            {{-- عرض عدد التقييمات --}}
                            <span class="text-xs text-gray-400 ml-2">({{ $book->ratings()->count() }} تقييم)</span>
                        </div>

                        {{-- أزرار القراءة والتحميل --}}
                        <div class="grid grid-cols-2 gap-3">
                            <a href="{{ asset('storage/' . $book->file_path) }}" target="_blank" class="bg-gray-100 py-2 rounded-xl text-center text-sm font-bold text-gray-700 hover:bg-gray-200 transition">📖 قراءة</a>
                            <a href="{{ route('books.download', $book->id) }}" class="bg-blue-600 text-white py-2 rounded-xl text-center text-sm font-bold hover:bg-blue-700 transition">📥 تحميل</a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-10 bg-gray-50 rounded-3xl border-2 border-dashed border-gray-200">
                        <p class="text-gray-500 font-bold italic">لا توجد كتب تطابق بحثك حالياً.</p>
                        <a href="{{ route('dashboard') }}" class="text-blue-600 underline text-sm mt-2 block">عرض كافة الكتب</a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>