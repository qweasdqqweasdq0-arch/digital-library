
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-right">
            {{ __('لوحة التحكم الرئيسية') }}
        </h2>
    </x-slot>

    <div class="py-12" dir="rtl">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 text-right">
            
            {{-- 1. أزرار التحكم العلوية --}}
            <div class="mb-8 flex flex-wrap gap-3 justify-start items-center">
                {{-- زر التقارير --}}
                <a href="{{ route('admin.reports') }}" class="bg-purple-600 text-white px-5 py-2 rounded-xl font-bold shadow hover:bg-purple-700 transition">📊 التقارير</a>
                
                {{-- زر إضافة تصنيف (يوجه إلى categories/create.blade.php) --}}
                <a href="{{ route('categories.create') }}" class="bg-gray-800 text-white px-5 py-2 rounded-xl font-bold shadow hover:bg-black transition">📂 إضافة تصنيف</a>
                
                {{-- زر إضافة كتاب --}}
                <a href="{{ route('books.create') }}" class="bg-blue-600 text-white px-5 py-2 rounded-xl font-bold shadow hover:bg-blue-700 transition">➕ إضافة كتاب</a>
            </div>

            {{-- 2. شبكة عرض الكتب --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($books as $book)
                    <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 hover:shadow-md transition">
                        
                        {{-- التصنيف والمفضلة --}}
                        <div class="flex justify-between items-start mb-4 flex-row-reverse">
                            <span class="text-xs font-bold bg-blue-50 text-blue-600 px-3 py-1 rounded-full">
                                {{ $book->category->name ?? 'عام' }}
                            </span>
                            
                            <form action="{{ route('books.favorite', $book->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-xl">
                                    {{ (auth()->user()->favorites ?? collect())->contains('book_id', $book->id) ? '❤️' : '🤍' }}
                                </button>
                            </form>
                        </div>

                        <h3 class="font-bold text-lg mb-2">{{ $book->title }}</h3>

                        {{-- 3. نظام تقييم النجوم التفاعلي --}}
                        <div class="flex items-center gap-1 mb-6" dir="ltr">
                            <form action="{{ route('books.rate', $book->id) }}" method="POST" class="flex flex-row-reverse items-center">
                                @csrf
                                @for ($i = 5; $i >= 1; $i--)
                                    <input type="radio" id="star{{ $i }}-{{ $book->id }}" name="rating" value="{{ $i }}" 
                                           class="hidden" onchange="this.form.submit()" 
                                           {{ round($book->averageRating() ?? 0) == $i ? 'checked' : '' }}>
                                    
                                    <label for="star{{ $i }}-{{ $book->id }}" 
                                           class="cursor-pointer text-2xl transition {{ round($book->averageRating() ?? 0) >= $i ? 'text-yellow-400' : 'text-gray-300' }} hover:text-yellow-500">
                                        ★
                                    </label>
                                @endfor
                            </form>
                            <span class="text-gray-400 text-xs ml-2">({{ number_format($book->averageRating() ?? 0, 1) }})</span>
                        </div>

                        {{-- 4. أزرار القراءة والتحميل --}}
                        <div class="grid grid-cols-2 gap-3">


<a href="{{ asset('storage/' . $book->file_path) }}" target="_blank" class="bg-gray-100 py-2 rounded-xl text-center text-sm font-bold hover:bg-gray-200 transition">📖 قراءة</a>
                            <a href="{{ route('books.download', $book->id) }}" class="bg-blue-600 text-white py-2 rounded-xl text-center text-sm font-bold hover:bg-blue-700 transition">📥 تحميل</a>
                        </div>
                    </div>
                @empty
                    <p class="col-span-full text-center text-gray-500 py-10">لا توجد كتب متاحة حالياً.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>