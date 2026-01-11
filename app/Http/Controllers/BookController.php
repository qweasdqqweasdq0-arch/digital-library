<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Models\Favorite;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    // عرض الكتب للجميع
    public function index(Request $request)
    {
        // 1. التعديل: أضفنا البحث بالمؤلف داخل دالة الـ where
        $query = Book::with(['category', 'ratings']);
    
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('author', 'like', '%' . $search . '%') // الحقل الجديد للفلترة
                  ->orWhere('description', 'like', '%' . $search . '%');
            });
        }
    
        // 2. التعديل: إضافة شرط التصنيف
        if ($request->sort == 'top_rated') {
            $query->withAvg('ratings', 'rating')->orderByDesc('ratings_avg_rating');
        } elseif ($request->sort == 'oldest') {
            $query->oldest(); // هذا سيقوم بالترتيب من الأقدم (حسب تاريخ الرفع)
        } else {
            $query->latest(); // الترتيب الافتراضي (الأحدث)
        }
    
        $books = $query->get();
        $categories = Category::all();
    
        return view('dashboard', compact('books', 'categories'));
        $books = $query->get();
        $categories = Category::all();
    
        return view('dashboard', compact('books', 'categories'));
    }

    // التقارير (محمية للأدمن فقط)
    public function reports()
    {
        // 1. حساب الإحصائيات العامة للكروت العلوية
        $stats = [
            'total_books'      => \App\Models\Book::count(),
            'total_users'      => \App\Models\User::count(),
            'categories_count' => \App\Models\Category::count(),
            'total_favorites' => \App\Models\Favorite::count(),
        ];
    
        // 2. جلب قائمة الكتب مع العلاقات لحساب التقييمات والتعليقات في الجدول
        $books = \App\Models\Book::with(['category', 'ratings', 'comments', 'favorites'])->get();
    
        // 3. تجهيز بيانات الرسم البياني (آخر 6 أشهر)
        $months = collect(range(5, 0))->reverse()->map(function($i) {
            $date = now()->subMonths($i);
            return [
                'month_name' => $date->translatedFormat('F'), // اسم الشهر بالعربي
                'count'      => \App\Models\Book::whereMonth('created_at', $date->month)
                                                ->whereYear('created_at', $date->year)
                                                ->count()
            ];
        });
    
        $chartLabels = $months->pluck('month_name');
        $chartData   = $months->pluck('count');
    
        // 4. إرسال البيانات للـ View
        return view('admin.reports', compact('stats', 'books', 'chartLabels', 'chartData'));
    }

    public function create()
    {
        if (!auth()->user()->hasRole('admin')) { abort(403); }
        $categories = Category::all();
        return view('books.create', compact('categories'));
    }public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255', // التحقق من صحة المدخل
            'category_id' => 'required|exists:categories,id',
            'description' => 'required',
            'file' => 'required|mimes:pdf|max:10000',
        ]);
    
        // رفع الملف وحفظ البيانات
        $path = $request->file('file')->store('books', 'public');
    
        Book::create([
            'title' => $request->title,
            'author' => $request->author, // حفظ اسم المؤلف
            'description' => $request->description,
            'category_id' => $request->category_id,
            'file_path' => $path,
            'user_id' => auth()->id(),
        ]);
    
        return redirect()->route('dashboard')->with('success', 'تم إضافة الكتاب بنجاح');
    }
    public function destroy(Book $book)
    {
        if (!auth()->user()->hasRole('admin')) { abort(403); }

        if (Storage::disk('public')->exists($book->file_path)) {
            Storage::disk('public')->delete($book->file_path);
        }
        $book->delete();
        return redirect()->route('dashboard')->with('success', 'تم حذف الكتاب');
    }

    public function download(Book $book)
    {
        if (Storage::disk('public')->exists($book->file_path)) {
            return Storage::disk('public')->download($book->file_path, $book->title);
        }
        return back()->with('error', 'الملف غير موجود.');
    }

    public function toggleFavorite(Book $book)
    {
        $favorite = Favorite::where('user_id', auth()->id())->where('book_id', $book->id)->first();
        if ($favorite) {
            $favorite->delete();
            return back();
        }
        Favorite::create(['user_id' => auth()->id(), 'book_id' => $book->id]);
        return back();
    }

    public function rate(Request $request, $id)
    {
        // 1. التحقق من المدخلات
        $request->validate([
            'rating' => 'required|integer|between:1,5'
        ]);
    
        // 2. تحديث تقييم المستخدم الحالي لهذا الكتاب إذا كان موجوداً، أو إنشاء واحد جديد
        // الشرط الأول (المصفوفة الأولى) هو ما يبحث عنه النظام ليعرف هل هذا التقييم موجود مسبقاً أم لا
        \App\Models\Rating::updateOrCreate(
            [
                'user_id' => auth()->id(), // يجب التأكد من أن المستخدم مسجل دخول
                'book_id' => $id
            ],
            [
                'rating' => $request->rating,
                'value'  => $request->rating  // تأكد أن اسم الحقل في قاعدة البيانات هو value أو rating
            ]
        );
    
        return back()->with('success', 'تم تقييم الكتاب بنجاح');
    }

    public function showFavorites()
    {
        $books = Book::whereHas('favorites', function($q) {
            $q->where('user_id', auth()->id());
        })->get();
        return view('favorites', compact('books'));
    }
}