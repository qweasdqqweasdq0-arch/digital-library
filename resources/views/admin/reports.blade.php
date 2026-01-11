
<x-app-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700;900&display=swap');
        body { font-family: 'Tajawal', sans-serif; }
    </style>

    <x-slot name="header">
        <div class="flex justify-between items-center flex-row-reverse py-2">
            <div class="text-right">
                <h2 class="font-black text-2xl text-gray-800 dark:text-gray-100 leading-tight">مركز البيانات والتحليلات 📊</h2>
                <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">مراقبة أداء المكتبة وتفاعل القراء</p>
            </div>
            <a href="{{ route('dashboard') }}" class="bg-white dark:bg-gray-700 border border-gray-200 px-6 py-2 rounded-xl text-gray-600 dark:text-gray-200 font-bold text-sm shadow-sm hover:bg-gray-50 transition">
                العودة للوحة التحكم
            </a>
        </div>
    </x-slot>

    <div class="py-12" dir="rtl">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- الكروت الإحصائية الرئيسية --}}
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-6 mb-10 text-right">
                
                <div class="bg-white dark:bg-gray-800 p-6 rounded-[2rem] shadow-sm border-r-8 border-blue-600 hover:scale-105 transition-transform">
                    <p class="text-gray-400 text-xs font-bold mb-1">إجمالي الكتب</p>
                    <div class="text-3xl font-black text-gray-900 dark:text-white">{{ $stats['total_books'] ?? 0 }}</div>
                    <span class="text-[10px] text-blue-600 font-bold">📚 محتوى رقمي</span>
                </div>

                <div class="bg-white dark:bg-gray-800 p-6 rounded-[2rem] shadow-sm border-r-8 border-green-600 hover:scale-105 transition-transform">
                    <p class="text-gray-400 text-xs font-bold mb-1">المستخدمين</p>
                    <div class="text-3xl font-black text-gray-900 dark:text-white">{{ $stats['total_users'] ?? 0 }}</div>
                    <span class="text-[10px] text-green-600 font-bold">👥 قراء نشطون</span>
                </div>

                <div class="bg-white dark:bg-gray-800 p-6 rounded-[2rem] shadow-sm border-r-8 border-yellow-500 hover:scale-105 transition-transform">
                    <p class="text-gray-400 text-xs font-bold mb-1">التقييمات</p>
                    <div class="text-3xl font-black text-gray-900 dark:text-white">{{ \App\Models\Rating::count() }}</div>
                    <span class="text-[10px] text-yellow-600 font-bold">⭐ آراء القراء</span>
                </div>

                <div class="bg-white dark:bg-gray-800 p-6 rounded-[2rem] shadow-sm border-r-8 border-purple-600 hover:scale-105 transition-transform">
                    <p class="text-gray-400 text-xs font-bold mb-1">المراجعات</p>
                    <div class="text-3xl font-black text-gray-900 dark:text-white">{{ \App\Models\Comment::count() }}</div>
                    <span class="text-[10px] text-purple-600 font-bold">💬 نقاشات حية</span>
                </div>

                <div class="bg-white dark:bg-gray-800 p-6 rounded-[2rem] shadow-sm border-r-8 border-red-600 hover:scale-105 transition-transform">
                    <p class="text-gray-400 text-xs font-bold mb-1">بالمفضلة</p>
                    <div class="text-3xl font-black text-gray-900 dark:text-white">{{ $stats['total_favorites'] ?? 0 }}</div>
                    <span class="text-[10px] text-red-600 font-bold">❤️ كتب مميزة</span>
                </div>

            </div>

            {{-- قسم الرسم البياني التحليلي --}}
            <div class="bg-white dark:bg-gray-800 p-8 rounded-[2.5rem] shadow-sm mb-12 border border-gray-50 dark:border-gray-700">
                <h3 class="text-xl font-black text-gray-800 dark:text-white mb-8 flex items-center gap-2">
                    <span>📈</span> إحصائيات رفع المحتوى (آخر 6 أشهر)
                </h3>
                <div class="h-[350px] relative">
                    <canvas id="libraryGrowthChart"></canvas>
                </div>
            </div>


{{-- جدول البيانات التفصيلي --}}
            <div class="bg-white dark:bg-gray-800 shadow-xl rounded-[2.5rem] overflow-hidden border border-gray-100 dark:border-gray-700">
                <div class="p-8 border-b border-gray-50 dark:border-gray-700 flex justify-between items-center bg-gray-50/30 dark:bg-gray-900/50">
                    <h3 class="text-xl font-black text-gray-800 dark:text-white">جدول تحليل أداء الكتب 📋</h3>
                    <button onclick="window.print()" class="bg-indigo-600 text-white px-6 py-2 rounded-xl hover:bg-indigo-700 font-bold text-sm shadow-lg transition flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" /></svg>
                        طباعة التقرير PDF
                    </button>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-right border-collapse">
                        <thead>
                            <tr class="bg-gray-100/50 dark:bg-gray-700/50 text-gray-500 dark:text-gray-400 text-xs font-black uppercase tracking-wider">
                                <th class="p-5 border-b dark:border-gray-700">الكتاب والمؤلف</th>
                                <th class="p-5 border-b dark:border-gray-700 text-center">التصنيف</th>
                                <th class="p-5 border-b dark:border-gray-700 text-center">التقييم العام</th>
                                <th class="p-5 border-b dark:border-gray-700 text-center">التفاعل</th>
                                <th class="p-5 border-b dark:border-gray-700 text-center">تاريخ النشر</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 dark:divide-gray-700 text-gray-700 dark:text-gray-200">
                            @forelse($books ?? [] as $book)
                                <tr class="hover:bg-indigo-50/20 dark:hover:bg-gray-700/30 transition">
                                    <td class="p-5">
                                        <div class="font-black text-sm text-gray-900 dark:text-white">{{ $book->title }}</div>
                                        <div class="text-[10px] text-indigo-500 font-bold">بواسطة: {{ $book->author ?? 'غير مسجل' }}</div>
                                    </td>
                                    <td class="p-5 text-center">
                                        <span class="bg-gray-100 dark:bg-gray-700 px-3 py-1 rounded-full text-[10px] font-bold">{{ $book->category->name ?? 'عام' }}</span>
                                    </td>
                                    <td class="p-5 text-center">
                                        <div class="flex justify-center items-center gap-1 text-yellow-500 font-black">
                                            <span>{{ number_format($book->ratings()->avg('rating') ?? 0, 1) }}</span>
                                            <span class="text-xs">★</span>
                                        </div>
                                    </td>
                                    <td class="p-5 text-center text-[11px] font-bold">
                                        <div class="flex justify-center gap-4">
                                            <span title="المراجعات">💬 {{ $book->comments()->count() }}</span>
                                            <span title="المفضلة" class="text-red-400">❤️ {{ $book->favorites()->count() }}</span>


</div>
                                    </td>
                                    <td class="p-5 text-center text-xs font-mono text-gray-400 italic">
                                        {{ $book->created_at->format('Y/m/d') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-20 text-center text-gray-400 font-bold italic">لا توجد سجلات بيانات حالياً.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-8 text-center text-gray-400 dark:text-gray-500 text-[10px] font-bold tracking-widest">
                تم استخراج هذا التقرير التحليلي بتاريخ: {{ now()->translatedFormat('d F Y - H:i') }}
            </div>
        </div>
    </div>

    {{-- مكتبة الرسوم البيانية --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('libraryGrowthChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($chartLabels ?? ['يناير', 'فبراير', 'مارس', 'ابريل', 'مايو', 'يونيو']) !!},
                    datasets: [{
                        label: 'الكتب المرفوعة',
                        data: {!! json_encode($chartData ?? [0,0,0,0,0,0]) !!},
                        borderColor: '#4f46e5',
                        backgroundColor: 'rgba(79, 70, 229, 0.1)',
                        borderWidth: 4,
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#4f46e5',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1e1b4b',
                            titleFont: { family: 'Tajawal', size: 14 },
                            bodyFont: { family: 'Tajawal', size: 13 },
                            padding: 12,
                            displayColors: false
                        }
                    },
                    scales: {
                        y: { 
                            beginAtZero: true, 
                            grid: { color: 'rgba(0,0,0,0.05)' },
                            ticks: { font: { family: 'Tajawal', weight: 'bold' } }
                        },
                        x: { 
                            grid: { display: false },
                            ticks: { font: { family: 'Tajawal', weight: 'bold' } }
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>