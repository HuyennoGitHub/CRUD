<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function get_all_product() {

        $products = Product::all();
        return response()->json($products);

    }


    public function add_product(Request $request){
        // dd($request->all());
        $product = new Product();
        $product->iden = $request->iden;
        $product->name = $request->name;
        $product->price = $request->price;
        if($request->hasFile('img')){
        $imgName = time().'.'.$request->file('img')->extension();
        $request->file('img')->move(public_path('upload'),$imgName);
        $product->image=$imgName;
        }else {
            $product->image = "image.png";
        }
        $product->save();

    }

    public function delete($id){
        // dd($id);
        $product = Product::find($id);
        $image_path = public_path()."/upload/";
        $image = $image_path.$product->image;
        if(file_exists($image)){
            @unlink($image);
        }
        $product->delete();
    }

    public function get_edit_product($id)   {
        $product = Product::find($id);
        return response()->json([
            'product' => $product
        ],200);
    }

    public function update_product(request $request, $id) {
        $product = Product::find($id);
        
        if (($request->iden!='')){
            $product->iden = $request->iden;
        };
        if (($request->name !='')){
            $product->name = $request->name;
        };
        if (($request->price != '')){
            $product->price = $request->price;
        };
        if(($product->image!=$request->image)&&($request->hasFile('img'))) {
            $imgName = time().'.'.$request->file('img')->extension();
            $request->file('img')->move(public_path('upload'),$imgName);
            $image = $upload_path. $product->image;
            if (file_exists($image)) {
                @unlink($image);
            }
            
        }else {
            $imgName = $product->image;
        };
        $product->image=$imgName;
        $product->save();
    }

    public function search_product(Request $request)
    {
        $search=$request->name;
        $dataName = DB::table('products')->where('name','like','%' . $search.'%')->get();
        return $dataName;
    }
}
