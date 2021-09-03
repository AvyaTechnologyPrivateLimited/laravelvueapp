<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Auth;

class ProductController extends Controller
{
    // all products
    public function index()
    {
        $products = Product::where('user_id', '=', Auth::id())->get()->toArray();
        return array_reverse($products);
    }

    // add product
    public function add(Request $request)
    {
        $file = '';
        $product = new Product([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'manufacture_year' => $request->manufacture_year,
            'photo' => $file
        ]);
        $product->save();

        return response()->json('The product successfully added');
    }

    // edit product
    public function edit($id)
    {
        $product = Product::where('user_id', '=', Auth::id())->find($id);
        return response()->json($product);
    }

    // update product
    public function update($id, Request $request)
    {
        $product = Product::where('id', '=', $id)->where('user_id', '=', Auth::id());
        $product->update($request->all());

        return response()->json('The product successfully updated');
    }

    // delete product
    public function delete($id)
    {
        $product = Product::where('id', '=', $id)->where('user_id', '=', Auth::id());
        $product->delete();

        return response()->json('The product successfully deleted');
    }
}
