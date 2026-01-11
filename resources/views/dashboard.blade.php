
<x-app-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700;900&display=swap');
        body { font-family: 'Tajawal', sans-serif; background-color: #f9fafb; } 
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #e0e7ff; border-radius: 10px; }
        .line-clamp-title { display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden; }
        .line-clamp-desc { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    </style>

    <x-slot name="header">
        <div class="flex justify-between items-center flex-row-reverse py-1">
            <div class="text-right">
                <h2 class="font-black text-2xl text-gray-800 dark:text-gray-100 leading-tight">مكتبتي الرقمية 📚</h2>
                <p class="text-gray-500 dark:text-gray-400 text-[11px] mt-0.5">استكشف وحمل أفضل الكتب العربية والعالمية</p>
            </div>
            <a href="{{ route('dashboard') }}" class="flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-xl shadow-lg transition-all transform hover:scale-105 font-bold text-xs">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                العودة 
            </a>
        </div>
    </x-slot>

    <div class="py-8" dir="rtl">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @role('admin')
            <div class="mb-6 flex flex-wrap gap-2">
                <a href="{{ route('books.create') }}" class="bg-indigo-600 text-white px-5 py-2.5 rounded-xl font-bold text-xs shadow hover:bg-indigo-700 transition">➕ إضافة كتاب</a>
                <a href="{{ route('categories.create') }}" class="bg-white border border-indigo-100 text-indigo-700 px-5 py-2.5 rounded-xl font-bold text-xs hover:bg-indigo-50 transition">📂 إضافة تصنيف</a>
                <a href="{{ route('admin.reports') }}" class="bg-gray-800 text-white px-5 py-2.5 rounded-xl font-bold text-xs shadow hover:bg-black transition">📊 التقارير</a>
            </div>
            @endrole

            <div class="bg-indigo-900 dark:bg-indigo-950 p-6 rounded-[2rem] shadow-xl mb-8">
                <form action="{{ route('dashboard') }}" method="GET" class="flex flex-col lg:flex-row gap-3">
                    <div class="flex-1 relative">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="ابحث بالعنوان، أو اسم المؤلف..." class="w-full pr-10 py-3 rounded-xl border-none focus:ring-2 focus:ring-indigo-500 text-sm dark:bg-gray-800 dark:text-white">
                        <span class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400">🔍</span>
                    </div>
                    <div class="flex flex-wrap md:flex-nowrap gap-2">
                        <select name="category_id" class="w-full md:w-36 py-3 rounded-xl border-none font-bold text-gray-600 text-xs dark:bg-gray-800 shadow-inner">
                            <option value="">كل الأقسام</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <select name="sort" class="w-full md:w-36 py-3 rounded-xl border-none font-bold text-gray-600 text-xs dark:bg-gray-800 shadow-inner">
                            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>⭐️ الأحدث</option>


<option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>⏳ الأقدم</option>
                            <option value="top_rated" {{ request('sort') == 'top_rated' ? 'selected' : '' }}>🔥 الأعلى تقييماً</option>
                        </select>
                        <button type="submit" class="bg-yellow-400 text-indigo-900 px-6 py-3 rounded-xl font-black text-xs hover:bg-yellow-500 transition shadow-lg">تحديث</button>
                    </div>
                </form>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @forelse($books as $book)
                    <div class="group bg-white dark:bg-gray-800 rounded-[2rem] shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden hover:shadow-xl transition-all flex flex-col h-full">
                        
                        <div class="h-24 bg-gradient-to-br from-indigo-50 to-blue-50 dark:from-indigo-900/40 flex items-center justify-center relative">
                            <span class="text-4xl group-hover:scale-110 transition duration-500">📖</span>
                            <span class="absolute top-2 right-2 bg-white/90 dark:bg-gray-700 px-2 py-0.5 rounded-lg text-[9px] font-black text-indigo-600 shadow-sm">{{ $book->category->name ?? 'عام' }}</span>
                        </div>

                        <div class="p-4 text-right flex-1 flex flex-col">
                            <h3 class="font-bold text-base text-gray-800 dark:text-white mb-0.5 line-clamp-title">{{ $book->title }}</h3>
                            <p class="text-indigo-600 dark:text-indigo-400 text-[10px] font-bold mb-2 italic">تأليف: {{ $book->author ?? 'غير معروف' }}</p>
                            <p class="text-gray-400 text-[11px] mb-4 line-clamp-desc leading-relaxed">{{ $book->description }}</p>
                            
                            <div class="grid grid-cols-2 gap-2 mb-4">
                                <a href="{{ asset('storage/' . $book->file_path) }}" target="_blank" class="bg-gray-50 dark:bg-gray-700 text-gray-600 dark:text-gray-200 py-2 rounded-lg text-[10px] font-bold text-center border border-gray-100 dark:border-gray-600">📖 قراءة</a>
                                <a href="{{ route('books.download', $book->id) }}" class="bg-indigo-600 text-white py-2 rounded-lg text-[10px] font-bold text-center shadow-md">📥 تحميل</a>
                            </div>

                            <div class="flex justify-between items-center pt-3 border-t border-gray-50 dark:border-gray-700 mb-4">
                                <form action="{{ route('books.favorite', $book->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-xl hover:scale-110 transition">{{ auth()->user()->favorites()->where('book_id', $book->id)->exists() ? '❤️' : '🤍' }}</button>
                                </form>
                                <div class="flex flex-col items-end">
                                    <div class="flex flex-row-reverse gap-0.5" dir="ltr">
                                        @php $avgRating = round($book->ratings()->avg('rating') ?? 0); @endphp
                                        @for ($i = 5; $i >= 1; $i--)
                                            <form action="{{ route('books.rate', $book->id) }}" method="POST" class="inline">@csrf<input type="hidden" name="rating" value="{{ $i }}"><button type="submit" class="text-sm {{ $avgRating >= $i ? 'text-yellow-400' : 'text-gray-200 dark:text-gray-600' }}">★</button></form>
                                        @endfor
                                    </div>
                                    <span class="text-[9px] text-gray-400">({{ $book->ratings()->count() }} تقييم)</span>
                                </div>
                            </div>


<div class="mt-auto bg-gray-50 dark:bg-gray-900/50 rounded-2xl p-3">
                                <h4 class="text-[10px] font-black text-gray-400 mb-2 italic">💬 المراجعات</h4>
                                <div class="space-y-3 max-h-32 overflow-y-auto pr-1 custom-scrollbar mb-3">
                                    @forelse($book->comments()->whereNull('parent_id')->latest()->get() as $comment)
                                        <div class="border-b border-white dark:border-gray-800 pb-2 last:border-0">
                                            <div class="flex justify-between items-center mb-1">
                                                <span class="text-[10px] font-black text-indigo-600">{{ $comment->user->name }}</span>
                                                <span class="text-[8px] text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                                            </div>
                                            <p class="text-[11px] text-gray-600 dark:text-gray-300 leading-snug mb-1">{{ $comment->comment }}</p>
                                            <div class="flex items-center gap-2">
                                                <form action="{{ route('comments.like', $comment->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="text-[9px] font-bold {{ $comment->likes()->where('user_id', auth()->id())->exists() ? 'text-blue-600' : 'text-gray-400' }}">👍 {{ $comment->likes()->count() }}</button>
                                                </form>
                                            </div>
                                            @foreach($comment->replies as $reply)
                                                <div class="mt-1 mr-2 bg-indigo-50/50 dark:bg-indigo-900/20 p-1.5 rounded-lg border-r-2 border-indigo-400 text-[10px] text-gray-500 italic">
                                                    {{ $reply->comment }}
                                                </div>
                                            @endforeach
                                        </div>
                                    @empty
                                        <p class="text-[9px] text-gray-400 text-center py-2 italic">لا توجد مراجعات..</p>
                                    @endforelse
                                </div>
                                <form action="{{ route('comments.store', $book->id) }}" method="POST" class="mt-2">
                                    @csrf
                                    <div class="flex gap-1">
                                        <input type="text" name="comment" required placeholder="أضف مراجعة..." class="flex-1 text-[10px] border-none bg-white dark:bg-gray-700 rounded-lg focus:ring-1 focus:ring-indigo-500 py-1">
                                        <button type="submit" class="bg-indigo-600 text-white p-1.5 rounded-lg hover:bg-indigo-700 transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" /></svg>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        @role('admin')
                        <div class="px-4 pb-4">
                            <form action="{{ route('books.destroy', $book->id) }}" method="POST" onsubmit="return confirm('حذف الكتاب؟');">
                                @csrf @method('DELETE')


<button type="submit" class="w-full bg-red-50 dark:bg-red-900/10 text-red-500 py-1.5 rounded-lg text-[10px] font-bold hover:bg-red-500 hover:text-white transition">🗑 حذف</button>
                            </form>
                        </div>
                        @endrole
                    </div>
                @empty
                    <div class="col-span-full text-center py-20 bg-white dark:bg-gray-800 rounded-[3rem] border-2 border-dashed border-gray-100">
                        <p class="text-gray-400 font-bold">لم نجد أي كتب تطابق بحثك..</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>