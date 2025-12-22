<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>مكتبتي الرقمية - الصفحة الرئيسية</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Cairo', sans-serif; }
    </style>
</head>
<body class="antialiased bg-gray-50">

    <nav class="bg-white shadow-sm p-4">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <div class="text-2xl font-bold text-blue-600 flex items-center gap-2">
                <span>📚</span>
                <span>مكتبتي الرقمية</span>
            </div>
            <div>
                @if (Route::has('login'))
                    <div class="flex gap-4">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-gray-700 hover:text-blue-600 font-bold">لوحة التحكم</a>
                        @else
                            <a href="{{ route('login') }}" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">تسجيل الدخول</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="border border-blue-600 text-blue-600 px-6 py-2 rounded-lg hover:bg-blue-50 transition">إنشاء حساب</a>
                            @endif
                        @endauth
                    </div>
                @endif
            </div>
        </div>
    </nav>

    <header class="py-16 bg-gradient-to-r from-blue-600 to-indigo-700 text-white">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h1 class="text-4xl md:text-6xl font-bold mb-6 italic">عالم من المعرفة بين يديك</h1>
            <p class="text-xl mb-10 text-blue-100 max-w-2xl mx-auto">تصفح، اقرأ، وشارك أفضل الكتب الرقمية في مختلف المجالات. مكتبتك الخاصة أصبحت الآن في جيبك.</p>
            <div class="flex justify-center gap-4">
                <a href="{{ route('register') }}" class="bg-white text-blue-700 px-8 py-3 rounded-full font-bold text-lg hover:shadow-lg transition">ابدأ الآن مجاناً</a>
                <a href="#features" class="bg-transparent border-2 border-white text-white px-8 py-3 rounded-full font-bold text-lg hover:bg-white hover:text-blue-700 transition">تعرف علينا</a>
            </div>
        </div>
    </header>

    <section id="features" class="py-20">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10 text-center">
                <div class="p-8 bg-white rounded-2xl shadow-sm hover:shadow-md transition">
                    <div class="text-4xl mb-4">📖</div>
                    <h3 class="text-xl font-bold mb-2">قراءة فورية</h3>
                    <p class="text-gray-600">اقرأ ملفات PDF مباشرة من المتصفح دون الحاجة لتحميل برامج إضافية.</p>
                </div>
                <div class="p-8 bg-white rounded-2xl shadow-sm hover:shadow-md transition">
                    <div class="text-4xl mb-4">❤️</div>
                    <h3 class="text-xl font-bold mb-2">قائمة المفضلة</h3>
                    <p class="text-gray-600">احتفظ بكتبك المميزة في مكان واحد للوصول إليها بسرعة لاحقاً.</p>
                </div>
                <div class="p-8 bg-white rounded-2xl shadow-sm hover:shadow-md transition">
                    <div class="text-4xl mb-4">⭐</div>
                    <h3 class="text-xl font-bold mb-2">تقييمات القراء</h3>
                    <p class="text-gray-600">شارك رأيك وقيّم الكتب لمساعدة الآخرين في اختيار قراءاتهم القادمة.</p>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-gray-800 text-gray-400 py-10 border-t border-gray-700 mt-20">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p>© {{ date('Y') }} مكتبتي الرقمية. جميع الحقوق محفوظة.</p>
        </div>
    </footer>

</body>
</html>