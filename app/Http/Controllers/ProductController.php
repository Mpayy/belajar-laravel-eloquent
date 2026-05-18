<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class ProductController extends Controller
{
    public function testOneToMany()
    {
        $product = Product::find(1);

        $category = $product->category;

        return response()->json([
            'data' => $category,
        ]);
    }

    public function testOneToOnePolymorphicProduct()
    {
        $product = Product::find('1');
        $image = $product->image;

        return response()->json([
            'product' => $product,
            'image' => $image,
        ]);
    }

    public function testOneToManyPolymorphic()
    {

        try {
            $product = Product::find('1');

            $comments = $product->comments;

            foreach ($comments as $comment) {
                return response()->json([
                    'product_name' => $product->name,
                    'comment' => $comment,
                    'commentable_id' => $comment->commentable_id,
                    'commentable_type' => $comment->commentable_type,
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Data not found',
                'error' => $th->getMessage(),
            ], 404);
        }
    }

    public function testOneOfManyPolymorphic()
    {
        $product = Product::find('1');

        $latestComment = $product->latestComment;
        $oldestComment = $product->oldestComment;

        return response()->json([
            'product_name' => $product->name,
            'latest_comment' => $latestComment,
            'oldest_comment' => $oldestComment,
        ]);
    }

    public function testManyToManyPolymorphic()
    {
        $product = Product::find("1");
        $tags = $product->tags;

        foreach ($tags as $tag) {
            return response()->json([
                'product_name' => $product->name,
                'tags' => $tag->name,
                'vouchers' => $tag->vouchers,
            ]);
        }
    }

    public function testEloquentCollection()
    {
        $products = Product::query()->get();

        $product = $products->toQuery()->where("price", '=', 200)->get();

        return response()->json([
            'products' => $product,
        ]);
    }

    public function testSerializationRelation()
    {
        try {
            $products = Product::get();
            $products->load(["category", "image"]);


            return response()->json([
                'products' => $products,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Data not found',
                'error' => $th->getMessage(),
            ], 404);
        }
    }
}
