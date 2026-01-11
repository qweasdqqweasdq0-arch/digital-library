<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center flex-row-reverse">
            <h2 class="font-black text-2xl text-gray-800 dark:text-gray-100 leading-tight text-right">
                {{ __('قائمة القراءة المفضلة ❤️') }}
            </h2>
            <a href="{{ route('dashboard') }}" class="flex items-center gap-2 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 px-4 py-2 rounded-xl text-gray-600 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 transition shadow-sm font-bold text-sm">
                <span>العودة للمكتبة</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
        </div>
    </x-slot>

    <div class="py-12" dir="rtl">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                @forelse($books as $book)
                    <div class="bg-white dark:bg-gray-800 rounded-[2rem] p-6 shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-xl transition-all duration-300 flex flex-col h-full">
                        <div class="flex justify-between items-start mb-6 flex-row-reverse">
                            <span class="text-[10px] font-black bg-indigo-50 dark:bg-indigo-900/40 text-indigo-600 dark:text-indigo-300 px-3 py-1.5 rounded-full uppercase tracking-wider">
                                {{ $book->category->name ?? 'عام' }}
                            </span>
                            <form action="{{ route('books.favorite', $book->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-red-50 dark:bg-red-900/20 p-2 rounded-full text-red-500 hover:bg-red-500 hover:text-white transition"> ❤️ </button>
                            </form>
                        </div>

                        <div class="mb-4 flex-grow text-right">
                            <h5 class="font-black text-xl mb-2 text-gray-800 dark:text-white leading-tight">{{ $book->title }}</h5>
                            <p class="text-gray-400 dark:text-gray-500 text-xs line-clamp-3">{{ $book->description }}</p>
                        </div>
                        
                        <div class="flex gap-2 mt-auto pt-6 border-t border-gray-50 dark:border-gray-700">
                            <a href="{{ asset('storage/' . $book->file_path) }}" target="_blank" 
                               class="flex-1 bg-gray-900 dark:bg-indigo-600 text-white text-center py-3 rounded-2xl font-black text-xs hover:bg-black transition shadow-lg shadow-gray-200 dark:shadow-none">
                                قراءة الكتاب
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-20 text-center bg-white dark:bg-gray-800 rounded-[3rem] shadow-sm border border-gray-100 dark:border-gray-700">
                        <div class="text-6xl mb-4">📚</div>
                        <p class="text-gray-400 text-lg font-bold">لم تضف أي كتب لمفضلتك بعد.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>