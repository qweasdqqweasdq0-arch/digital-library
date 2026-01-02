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
    // استبدل دالة index القديمة بهذا الكود
public function index(Request $request)
{
    // تحميل الكتب مع التصنيف الخاص بها
    $query = Book::with('category');

    // 1. فلترة البحث (بالعنوان أو الوصف)
    if ($request->filled('search')) {
        $query->where(function($q) use ($request) {
            $q->where('title', 'like', '%' . $request->search . '%')
              ->orWhere('description', 'like', '%' . $request->search . '%');
        });
    }

    // 2. فلترة التصنيف (إذا تم اختياره)
    if ($request->filled('category_id')) {
        $query->where('category_id', $request->category_id);
    }

    $books = $query->latest()->get();
    
    // نحتاج جلب التصنيفات لعرضها في قائمة الاختيار (Dropdown)
    $categories = Category::all();

    return view('dashboard', compact('books', 'categories'));
}

    // التقارير (محمية للأدمن فقط)
    public function reports()
    {
        if (!auth()->user()->hasRole('admin')) { abort(403); }

        $stats = [
            'total_books' => Book::count(),
            'total_users' => \App\Models\User::count(),
            'total_favorites' => Favorite::count(),
            'categories_count' => Category::count(),
        ];

        $books = Book::with('category')->get();
        return view('admin.reports', compact('stats', 'books'));
    }

    public function create()
    {
        if (!auth()->user()->hasRole('admin')) { abort(403); }
        $categories = Category::all();
        return view('books.create', compact('categories'));
    }

    public function store(Request $request)
    {
        if (!auth()->user()->hasRole('admin')) { abort(403); }

        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'category_id' => 'required|exists:categories,id',
            'file' => 'required|mimes:pdf,epub|max:10240',
        ]);

        $path = $request->file('file')->store('books_files', 'public');

        Book::create([
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'file_path' => $path,
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