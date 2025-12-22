<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookController;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// الصفحة الرئيسية
Route::get('/', function () {
    return view('welcome');
});
Route::get('/admin/reports', [BookController::class, 'reports'])->name('admin.reports');
// مسار إصلاح الصلاحيات (قم بزيارته مرة واحدة في المتصفح)
Route::get('/force-admin', function () {
    // التأكد من وجود الرتب
    $adminRole = Role::firstOrCreate(['name' => 'admin']);
    $userRole = Role::firstOrCreate(['name' => 'user']);

    // جلب المستخدم الحالي (أول مستخدم مسجل)
    $user = User::first();

    if ($user) {
        // إعطاؤه دور الأدمن ومسح أي أدوار قديمة
        $user->syncRoles([$adminRole]);
        return "تم تحديث رتبتك إلى Admin بنجاح! اذهب الآن لصفحة Dashboard.";
    }

    return "لم يتم العثور على أي مستخدم. يرجى التسجيل أولاً.";
});
Route::get('/favorites', [BookController::class, 'showFavorites'])->name('favorites.index');
Route::get('/books/{book}/download', [BookController::class, 'download'])->name('books.download');
Route::get('/dashboard', [BookController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/admin/reports', [BookController::class, 'generateReport'])->name('admin.reports');
// مسارات الكتب (إضافة، عرض، حذف)
Route::middleware('auth')->group(function () {
    Route::resource('books', BookController::class);
});
Route::post('/books/{book}/favorite', [BookController::class, 'toggleFavorite'])->name('books.favorite');
Route::post('/books/{book}/rate', [BookController::class, 'rate'])->name('books.rate');
// مسارات البروفايل (تأتي جاهزة مع Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});use App\Http\Controllers\CategoryController;
Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
// مسارات التصنيفات
Route::resource('categories', App\Http\Controllers\CategoryController::class);

Route::post('/books/{id}/rate', [App\Http\Controllers\BookController::class, 'rate'])->name('books.rate');
// مسار التقييم بالنجوم
Route::post('/books/{id}/rate', [App\Http\Controllers\BookController::class, 'rate'])->name('books.rate');// مسارات التصنيفات
Route::resource('categories', App\Http\Controllers\CategoryController::class);

// مسار التقييم بالنجوم
Route::post('/books/{id}/rate', [App\Http\Controllers\BookController::class, 'rate'])->name('books.rate');
require __DIR__.'/auth.php';