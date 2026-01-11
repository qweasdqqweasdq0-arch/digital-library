<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Route;

// 1. الصفحة الرئيسية
Route::get('/', function () {
    return view('welcome');
});

// 2. مسارات المستخدمين المسجلين (أي مستخدم)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [BookController::class, 'index'])->name('dashboard');
    Route::get('/favorites', [BookController::class, 'showFavorites'])->name('favorites.index');
    Route::get('/books/{book}/download', [BookController::class, 'download'])->name('books.download');
    Route::post('/books/{book}/favorite', [BookController::class, 'toggleFavorite'])->name('books.favorite');
    Route::post('/books/{id}/rate', [BookController::class, 'rate'])->name('books.rate');

    // ملف الشخصي
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 3. مسارات الإدارة (للأدمن فقط)
Route::middleware(['auth', 'role:admin'])->group(function () {
    // التقارير
    Route::get('/admin/reports', [BookController::class, 'reports'])->name('admin.reports');
    
    // إدارة الكتب (إضافة، تعديل، حذف)
    Route::get('/books/create', [BookController::class, 'create'])->name('books.create');
    Route::post('/books', [BookController::class, 'store'])->name('books.store');
    Route::delete('/books/{book}', [BookController::class, 'destroy'])->name('books.destroy');
    
    // إدارة التصنيفات
    Route::resource('categories', CategoryController::class);
});

// 4. مسار إصلاح الصلاحيات (للطوارئ)
Route::get('/force-admin', function () {
    $adminRole = Role::firstOrCreate(['name' => 'admin']);
    $userRole = Role::firstOrCreate(['name' => 'user']);
    $user = User::first();
    if ($user) {
        $user->syncRoles([$adminRole]);
        return "تم تحديث رتبتك إلى Admin بنجاح!";
    }
    return "لا يوجد مستخدمين.";
});
Route::post('/comments/{comment}/like', [App\Http\Controllers\CommentController::class, 'toggleLike'])->name('comments.like');
Route::post('/books/{book}/comments', [App\Http\Controllers\CommentController::class, 'store'])->name('comments.store');
require __DIR__.'/auth.php';