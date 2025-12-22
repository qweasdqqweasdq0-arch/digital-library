<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-right">
            {{ __('كتبك المفضلة') }}
        </h2>
    </x-slot>

    <div class="py-12" dir="rtl">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                
                <div class="mb-8 text-right">
                    <h3 class="text-2xl font-bold text-gray-800">قائمة القراءة الخاصة بك ❤️</h3>
                    <p class="text-gray-500">هنا تجد جميع الكتب التي قمت بحفظها للرجوع إليها لاحقاً.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @forelse($books as $book)
                        <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm hover:shadow-xl transition-all duration-300">
                            <div class="flex justify-between items-start mb-6 flex-row-reverse">
                                <span class="text-xs font-bold bg-blue-50 text-blue-600 px-3 py-1.5 rounded-lg">
                                    {{ $book->category->name ?? 'عام' }}
                                </span>
                                {{-- زر إزالة من المفضلة --}}
                                <form action="{{ route('books.favorite', $book->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-red-500 text-xl">❤️</button>
                                </form>
                            </div>

                            <h5 class="font-bold text-xl mb-2 text-gray-800 text-right">{{ $book->title }}</h5>
                            
                            <div class="flex gap-2 mt-6">
                                <a href="{{ asset('storage/' . $book->file_path) }}" target="_blank" 
                                   class="flex-1 bg-gray-900 text-white text-center py-3 rounded-xl font-bold hover:bg-black transition">
                                    قراءة الآن
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-20 text-center">
                            <div class="text-6xl mb-4">📝</div>
                            <p class="text-gray-400 text-lg font-bold">قائمة مفضلتك فارغة حالياً.</p>
                            <a href="{{ route('dashboard') }}" class="text-blue-600 hover:underline mt-2 inline-block">تصفح الكتب وأضف بعضها هنا</a>
                        </div>
                    @endforelse
                </div>
                
            </div>
        </div>
    </div>
</x-app-layout>