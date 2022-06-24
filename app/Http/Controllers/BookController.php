<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Book;
use App\Models\Tampung;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class BookController extends Controller
{
    public function index()
    {
        $book = Book::get();
        $category = Category::get();

        foreach ($book as $key => $value) {
            $tampung = Tampung::where('book_id',$value->id)->join('categories as b','b.id','tampungs.category_id')->select('b.name')->get();
            $tamp = [];
            foreach($tampung as $data){
                $tamp[] = $data->name;
            }
            $book[$key]->category = implode(', ',$tamp);
        }
        
        return view('book.index',compact('book','category'));
    }

    public function store(Request $request)
    {
        if($request->stock < 0){
            return Redirect::back()->withErrors(['msg' => 'Stok tidak boleh kurang daripada 1']);
        }

        $price = str_replace(".", "", $request->price);
        $insert = Book::insertGetId([
            'tittle' => $request->tittle,
            'description' => $request->description,
            'category_id' => '',
            'keywords' => $request->keyword,
            'price' => $price,
            'stock' => $request->stock,
            'publisher' => $request->publisher,
            'created_at' => now()
        ]);

        foreach ($request->category as $key => $value) {
            $category = Tampung::insert([
                'category_id' => $value,
                'book_id' => $insert
            ]);
        }

        return Redirect::back()->withErrors(['msg' => 'Success Insert Book']);

    }

    public function destroy($id)
    {
        $insert = Book::where('id',$id)->delete();

        return Redirect::back()->withErrors(['msg' => 'Book has been deleted']);
    }

    public function edit($id)
    {
        $book = Book::where('id',$id)->first();
        $category = Category::get();
        $tampung = Tampung::where('book_id',$id)->join('categories as b','b.id','tampungs.category_id')->select('b.name')->get();
        $tamp = [];
        foreach($tampung as $data){
            $tamp[] = $data->name;
        }
        $book->category = implode(', ',$tamp);

        return view('book.edit',compact('book','category'));
    }

    public function update(Request $request)
    {
        if($request->stock < 0){
            return Redirect::back()->withErrors(['msg' => 'Stok tidak boleh kurang daripada 1']);
        }

        $price = str_replace(".", "", $request->price);

        $insert = Book::where('id',$request->id)->update([
            'tittle' => $request->tittle,
            'description' => $request->description,
            'category_id' => '',
            'keywords' => $request->keyword,
            'price' => $price,
            'stock' => $request->stock,
            'publisher' => $request->publisher,
            'updated_at' => now()
        ]);

        if($request->category != null){
            $hapus = Tampung::where('book_id',$request->id)->delete();
            foreach ($request->category as $key => $value) {
                $category = Tampung::insert([
                    'category_id' => $value,
                    'book_id' => $insert
                ]);
            }
        }

        return redirect('/book');

    }
}
