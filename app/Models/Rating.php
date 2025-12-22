<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    // أضف هذا السطر لحل المشكلة التي ظهرت في الصورة
    protected $fillable = ['user_id', 'book_id','rating' ,'value'];

    // علاقة التقييم بالمستخدم (اختياري)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // علاقة التقييم بالكتاب (اختياري)
    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}