<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;

class CategoryController extends Controller
{
    //pagina per categorie
    public function show($id){
        $category = Category::find($id);

        return view('admin.categories.show', compact('category'));
    }
}
