<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // all books
    public function index()
    {
        $books = Product::all()->toArray();
        return array_reverse($books);
    }

    // add book
    public function add(Request $request)
    {
        $file = '';
        $book = new Product([
            'name' => $request->name,
            'manufacture_year' => $request->manufacture_year,
            'photo' => $file
        ]);
        $book->save();

        return response()->json('The product successfully added');
    }

    // edit book
    public function edit($id)
    {
        $book = Product::find($id);
        return response()->json($book);
    }

    // update book
    public function update($id, Request $request)
    {
        $book = Product::find($id);
        $book->update($request->all());

        return response()->json('The product successfully updated');
    }

    // delete book
    public function delete($id)
    {
        $book = Product::find($id);
        $book->delete();

        return response()->json('The product successfully deleted');
    }
}
