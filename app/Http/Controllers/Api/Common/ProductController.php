<?php

namespace App\Http\Controllers\Api\Common;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function getProduct()
    {
        $product = Product::orderBy('id', 'DESC')->get();
        if (!empty($product)) {
            return response()->json([
                'status' => true,
                'data' => $product
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'data' => $product
            ], 200);
        }
    }

    public function getSingleProduct($id)
    {
        $product = Product::with('images')->where('id', '=', $id)->first();
        if (!$product->isEmpty()) {
            return response()->json([
                'status' => true,
                'data' => $product
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'data' => $product
            ], 200);
        }
    }
}
