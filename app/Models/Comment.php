<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //
    public function likes() {
        return $this->hasMany(\App\Models\CommentLike::class);
    }
    // لجلب الردود الخاصة بهذا التعليق
public function replies() {
    return $this->hasMany(Comment::class, 'parent_id');
}

// للتأكد من هوية صاحب الرد (هل هو الأدمن أو المؤلف؟)
public function isAuthorOrAdmin($bookAuthorId) {
    return $this->user_id === $bookAuthorId || $this->user->hasRole('admin');
}
protected $fillable = ['user_id', 'book_id', 'comment', 'parent_id'];

public function user() {
    return $this->belongsTo(User::class);
}
}
