<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;


class CategoryController extends Controller
{
    public function index()
    {
        $category = Category::get();
        
        return view('category.index',compact('category'));
    }
    
    public function store(Request $request)
    {
        $insert = Category::insert([
            'name' => $request->name,
            'created_at' => now()
        ]);

        return Redirect::back()->withErrors(['msg' => 'Success Insert']);
    }

    public function edit($id)
    {
        $category = Category::where('id',$id)->first();
        return view('category.edit',compact('category'));
    }

    public function update(Request $request)
    {        
        $update = Category::where('id',$request->id)->update([
            'name' => $request->name,
            'updated_at' => now()
        ]);

        return redirect('/category');
    }

    public function destroy($id)
    {
        $delete = Category::where('id',$id)->delete();

        return Redirect::back()->withErrors(['msg' => 'The Message']);
    }
}
