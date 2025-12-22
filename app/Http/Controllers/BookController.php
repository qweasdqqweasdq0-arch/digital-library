<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Favorite;
use App\Models\Rating; 

class BookController extends Controller
{
    // دالة عرض الكتب في لوحة التحكم (Dashboard)
 // دالة الداشبورد (تعرض كل شيء ما عدا كروت التقارير)

 public function index(Request $request)
 {
     $query = Book::with('category');
 
     // أولاً: البحث بالنص (الاسم)
     if ($request->filled('search')) {
         $query->where('title', 'like', '%' . $request->search . '%');
     }
 
     // ثانياً: الفلترة والترتيب
     if ($request->filled('sort')) {
         switch ($request->sort) {
             case 'name_asc':
                 $query->orderBy('title', 'asc'); // من الألف إلى الياء
                 break;
             case 'name_desc':
                 $query->orderBy('title', 'desc'); // من الياء إلى الألف
                 break;
             case 'newest':
                 $query->latest(); // الأحدث أولاً
                 break;
             case 'oldest':
                 $query->oldest(); // الأقدم أولاً
                 break;
             default:
                 $query->latest();
         }
     } else {
         $query->latest(); // الترتيب الافتراضي (الأحدث)
     }
 
     $books = $query->get();
 
     return view('dashboard', compact('books'));
 }
// دالة التقارير المنفصلة
public function reports()
{
    // 1. جمع البيانات
    $totalBooks = \App\Models\Book::count();
    $totalUsers = \App\Models\User::count();
    $totalFavs = \App\Models\Favorite::count();
    $totalCats = \App\Models\Category::count();

    // 2. وضعها في مصفوفة stats
    $stats = [
        'total_books' => $totalBooks,
        'total_users' => $totalUsers,
        'total_favorites' => $totalFavs,
        'categories_count' => $totalCats,
    ];

    // 3. جلب قائمة الكتب للجدول
    $books = \App\Models\Book::with('category')->get();

    // 4. التمرير للصفحة (تأكد أن الاسم هنا مطابق للاسم في ملف الـ blade)
    return view('admin.reports', compact('stats', 'books'));
}
    public function download(Book $book)
{
    // التحقق من وجود الملف في التخزين
    if (Storage::disk('public')->exists($book->file_path)) {
        // تحميل الملف مع إعطائه اسماً مناسباً (اسم الكتاب)
        return Storage::disk('public')->download(
            $book->file_path, 
            $book->title . '.' . pathinfo($book->file_path, PATHINFO_EXTENSION)
        );
    }

    return back()->with('error', 'نعتذر، الملف غير موجود حالياً.');
}
    public function showFavorites()
{
    // جلب الكتب التي أضافها المستخدم الحالي للمفضلة فقط
    $books = Book::whereHas('favorites', function($query) {
        $query->where('user_id', auth()->id());
    })->with('category')->latest()->get();

    return view('favorites', compact('books'));
}
    public function generateReport() {
        $books = Book::with('category')->get();
        return view('admin.reports', compact('books'));
    }
    public function destroy(Book $book)
{
    // حذف الملف الفعلي من التخزين
    if (Storage::disk('public')->exists($book->file_path)) {
        Storage::disk('public')->delete($book->file_path);
    }

    // حذف السجل من قاعدة البيانات
    $book->delete();

    return redirect()->route('dashboard')->with('success', 'تم حذف الكتاب بنجاح');
}

    // دالة عرض صفحة إضافة كتاب جديد
    public function create()
    {
        $categories = Category::all();
        return view('books.create', compact('categories'));
    }

    // دالة حفظ الكتاب الجديد في قاعدة البيانات
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'category_id' => 'required|exists:categories,id',
            'file' => 'required|mimes:pdf,epub|max:10240', // كحد أقصى 10 ميجابايت
        ]);

        // تخزين ملف الكتاب في مجلد storage/app/public/books_files
        $path = $request->file('file')->store('books_files', 'public');

        // إنشاء سجل الكتاب
        Book::create([
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'file_path' => $path,
        ]);

        return redirect()->route('dashboard')->with('success', 'تم إضافة الكتاب بنجاح إلى المكتبة');
    }

    public function toggleFavorite(Book $book) {
        $favorite = \App\Models\Favorite::where('user_id', auth()->id())->where('book_id', $book->id)->first();
        if ($favorite) {
            $favorite->delete();
            return back()->with('success', 'تمت الإزالة من المفضلة');
        }
        \App\Models\Favorite::create(['user_id' => auth()->id(), 'book_id' => $book->id]);
        return back()->with('success', 'تمت الإضافة للمفضلة');
    }
    
    


public function rate(Request $request, $id)
{
    // التأكد من أن التقييم بين 1 و 5
    $request->validate([
        'rating' => 'required|integer|between:1,5',
    ]);

    // حفظ التقييم أو تحديثه إذا كان المستخدم قد قيم الكتاب سابقاً
   
Rating::updateOrCreate(
    ['user_id' => auth()->id(), 'book_id' => $id],
    [
        'rating' => $request->rating,
        'value'  => $request->rating, // نرسل القيمة للحقلين معاً لضمان النجاح
    ]
);

    return back()->with('success', 'تم التقييم بنجاح!');
}
}