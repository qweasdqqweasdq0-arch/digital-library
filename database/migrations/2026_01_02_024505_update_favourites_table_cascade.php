<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('favorites', function (Blueprint $table) {
            $table->dropForeign(['book_id']); // حذف الربط القديم
            $table->foreign('book_id')
                  ->references('id')->on('books')
                  ->onDelete('cascade'); // إضافة الربط الجديد مع خاصية الحذف التلقائي
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
