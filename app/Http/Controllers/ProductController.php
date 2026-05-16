<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function testOneToMany()
    {
        $product = Product::find(1);

        $category = $product->category;

        return response()->json([
            "data" => $category
        ]);
    }
}
