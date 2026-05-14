<?php

namespace App\Http\Controllers;

use App\Models\Category;


class CategoryController extends Controller
{
    public function testInsert()
    {
        
        // try {
        //     $category = new Category();
        //     $category->id = $request->id;
        //     $category->name = $request->name;
        //     $result = $category->save();
        // return response()->json(["result" => $result]);
        // } catch (\Exception $e) {
        //     return response()->json(["error" => $e->getMessage()], 500);
        // }

        $category = new Category();
        $category->id = "COMPUTER";
        $category->name = "computer";
        $result = $category->save();
        return response()->json($result);
    }

    public function testInsertMany()
    {
        $categories = [];
        for ($i = 0; $i < 10; $i++) {
            $categories[] = [
                "id" => "ID $i",
                "name"=> "Name $i",
            ];
        }

        // $result = Category::query()->insert($categories);
        $result = Category::insert($categories);
        $total = Category::count();
        return response()->json([
            "result" => $result,
            "total" => $total
        ]);
    }


    
}
