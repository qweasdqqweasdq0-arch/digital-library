<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


namespace App\Models;
use App\Models\Favorite;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = ['title', 'description', 'file_path', 'category_id'];

    // أضف هذه الدالة ليعرف النظام أن الكتاب ينتمي لتصنيف معين
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function favorites() { return $this->hasMany(Favorite::class); }
   
    
    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }
    
    public function averageRating()
    {
        // يحسب المتوسط من حقل rating، وإذا لم يجده يجرب حقل value
        $avg = $this->ratings()->avg('rating');
        if (!$avg) {
            $avg = $this->ratings()->avg('value');
        }
        return $avg ?: 0;
    }
}

