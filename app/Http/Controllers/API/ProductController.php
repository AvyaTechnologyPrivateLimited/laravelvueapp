<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Auth;
use Validator;

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

        $validator = Validator::make($request->all(), [
	        'name' => ['required', 'unique:products,name'],
	        'manufacture_year' => ['required'],
            'image' => ['mimes:jpg,jpeg,png']
	    ]);

	    if($validator->fails()) {
	        return response()->json(['success' => false,'message' => $validator->messages()]);
	    }

        

        if($request->file()) {
            
            $imageName = time().'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('upload'), $imageName);
            $file = 'upload/'.$imageName;
        } else {
            $file = 'upload/no-image.png';
        }

        
        $product = new Product([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'manufacture_year' => $request->manufacture_year,
            'photo' => $file
        ]);
        $product->save();

        $message = 'The product successfully added';
        return response()->json(['success' => true,'message' => $message]);
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

        //return $request->all();
        $validator = Validator::make($request->all(), [
	        'name' => ['required'],
	        'manufacture_year' => ['required'],
            'image' => ['mimes:jpg,jpeg,png']
	    ]);

	    if($validator->fails()) {
	        return response()->json(['success' => false,'message' => $validator->messages()]);
	    }

        if($request->file()) {
            
            $imageName = time().'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('upload'), $imageName);
            $file = 'upload/'.$imageName;
        } else {
            $product = Product::where('id', '=', $id)->where('user_id', '=', Auth::id())->first();
            $file = $product->photo;
        }

        $product = Product::where('id', '=', $id)->where('user_id', '=', Auth::id());
        $product->update([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'manufacture_year' => $request->manufacture_year,
            'photo' => $file
        ]);

        $message = 'The product successfully updated';
        return response()->json(['success' => true,'message' => $message]);
    }

    // delete product
    public function delete($id)
    {
        $image = Product::where('id', '=', $id)->where('user_id', '=', Auth::id())->first();
        if($image->photo != 'upload/no-image.png') {
            if($image->photo != '') {
                unlink(public_path('/').$image->photo);
            }
        }
        $product = Product::where('id', '=', $id)->where('user_id', '=', Auth::id());
        $product->delete();
        

        $message = 'The product successfully deleted';
        return response()->json(['success' => true,'message' => $message]);
    }
}
