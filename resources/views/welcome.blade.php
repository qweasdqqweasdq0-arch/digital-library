
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>مكتبتي الرقمية - الصفحة الرئيسية</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
        }
        // سكربت فحص الوضع الليلي
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
    <style> body { font-family: 'Cairo', sans-serif; } </style>
</head>
<body class="antialiased bg-gray-50 dark:bg-gray-900 transition-colors duration-300">

    <nav class="bg-white dark:bg-gray-800 shadow-sm p-4 transition-colors">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <div class="text-2xl font-bold text-blue-600 dark:text-blue-400 flex items-center gap-2">
                <span>📚</span>
                <span>مكتبتي الرقمية</span>
            </div>
            <div class="flex items-center gap-4">
                {{-- زر تبديل الوضع --}}
                <button id="theme-toggle" class="p-2 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                    <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
                    <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path></svg>
                </button>

                @if (Route::has('login'))
                    <div class="flex gap-4 items-center">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-gray-700 dark:text-gray-200 hover:text-blue-600 font-bold">لوحة التحكم</a>
                        @else
                            <a href="{{ route('login') }}" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">تسجيل الدخول</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="border border-blue-600 text-blue-600 dark:text-blue-400 dark:border-blue-400 px-6 py-2 rounded-lg hover:bg-blue-50 transition">إنشاء حساب</a>
                            @endif
                        @endauth
                    </div>
                @endif
            </div>
        </div>
    </nav>

    <header class="py-16 bg-gradient-to-r from-blue-600 to-indigo-700 dark:from-indigo-900 dark:to-blue-900 text-white">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h1 class="text-4xl md:text-6xl font-bold mb-6 italic">عالم من المعرفة بين يديك</h1>
            <p class="text-xl mb-10 text-blue-100 max-w-2xl mx-auto">تصفح، اقرأ، وشارك أفضل الكتب الرقمية في مختلف المجالات. مكتبتك الخاصة أصبحت الآن في جيبك.</p>


<div class="flex justify-center gap-4">
                <a href="{{ route('register') }}" class="bg-white text-blue-700 px-8 py-3 rounded-full font-bold text-lg hover:shadow-lg transition">ابدأ الآن مجاناً</a>
            </div>
        </div>
    </header>

    <section id="features" class="py-20">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10 text-center">
                <div class="p-8 bg-white dark:bg-gray-800 rounded-2xl shadow-sm border dark:border-gray-700 transition">
                    <div class="text-4xl mb-4">📖</div>
                    <h3 class="text-xl font-bold mb-2 dark:text-white">قراءة فورية</h3>
                    <p class="text-gray-600 dark:text-gray-400">اقرأ ملفات PDF مباشرة من المتصفح دون الحاجة لتحميل برامج إضافية.</p>
                </div>
                <div class="p-8 bg-white dark:bg-gray-800 rounded-2xl shadow-sm border dark:border-gray-700 transition">
                    <div class="text-4xl mb-4">❤️</div>
                    <h3 class="text-xl font-bold mb-2 dark:text-white">قائمة المفضلة</h3>
                    <p class="text-gray-600 dark:text-gray-400">احتفظ بكتبك المميزة في مكان واحد للوصول إليها بسرعة لاحقاً.</p>
                </div>
                <div class="p-8 bg-white dark:bg-gray-800 rounded-2xl shadow-sm border dark:border-gray-700 transition">
                    <div class="text-4xl mb-4">⭐️</div>
                    <h3 class="text-xl font-bold mb-2 dark:text-white">تقييمات القراء</h3>
                    <p class="text-gray-600 dark:text-gray-400">شارك رأيك وقيّم الكتب لمساعدة الآخرين في اختيار قراءاتهم القادمة.</p>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-gray-800 dark:bg-black text-gray-400 py-10 border-t border-gray-700">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p>© {{ date('Y') }} مكتبتي الرقمية. جميع الحقوق محفوظة.</p>
        </div>
    </footer>

    <script>
        var themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
        var themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            themeToggleLightIcon.classList.remove('hidden');
        } else {
            themeToggleDarkIcon.classList.remove('hidden');
        }

        var themeToggleBtn = document.getElementById('theme-toggle');
        themeToggleBtn.addEventListener('click', function() {
            themeToggleDarkIcon.classList.toggle('hidden');
            themeToggleLightIcon.classList.toggle('hidden');

            if (localStorage.getItem('color-theme')) {
                if (localStorage.getItem('color-theme') === 'light') {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('color-theme', 'dark');
                } else {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('color-theme', 'light');
                }
            } else {
                if (document.documentElement.classList.contains('dark')) {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('color-theme', 'light');
                } else {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('color-theme', 'dark');
                }
            }
        });
    </script>
</body>
</html>