<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


namespace App\Models;
use App\Models\Favorite;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
   // أضف هذه الحقول فقط داخل المصفوفة الموجودة لديك
protected $fillable = ['title', 'author', 'description', 'file_path', 'category_id', 'user_id'];

    // أضف هذه الدالة ليعرف النظام أن الكتاب ينتمي لتصنيف معين
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function favorites() { return $this->hasMany(Favorite::class); }
   
    
    public function ratings() {
        return $this->hasMany(Rating::class);
    }
    
    public function averageRating() {
        return $this->ratings()->avg('rating'); // أو 'value' حسب اسم الحقل عندك
    }
    public function comments() {
        return $this->hasMany(Comment::class)->latest();
    }
}

