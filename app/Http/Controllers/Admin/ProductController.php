<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImages;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $product = Product::latest()->get();
        return view('Admin.Product.index',compact('product'));
    }

    public function create()
    {
        return view('Admin.Product.create');
    }

    public function store(Request $request)
    {
        if ($request->hasFile('main_img')) {
            $file = $request->file('main_img');
            $filename = $file->getClientOriginalName();
            $move = $file->move('public/storage/product/',$filename);
            $host = request()->getSchemeAndHttpHost();
            $url = $host.'/pharmassist/'.$move;
        }

        $product = new Product;
        $product->name = $request->name;
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->status = $request->status;
        $product->description = $request->description;
        $product->main_img = $url;
        $product->save();

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $files) {
                $filenames = $files->getClientOriginalName();
                $moves = $files->move('public/storage/product/',$filenames);
                $hosts = request()->getSchemeAndHttpHost();
                $urls = $moves.'/pharmassist/'.$hosts;

                ProductImages::create([
                    'product_id' => $product->id,
                    'images' => $urls
                ]);
            }
        }

        return response()->json([
            'status' => true,
            'msg' => 'Product added successfully!'
        ]);
    }
}
