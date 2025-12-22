<?php
namespace App\Http\Controllers;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller {
    public function create() {
        return view('categories.create');
    }

    public function store(Request $request) {
        $request->validate(['name' => 'required|unique:categories']);
        Category::create(['name' => $request->name]);
        return redirect()->route('dashboard')->with('success', 'تم إضافة التصنيف بنجاح');
    }
}