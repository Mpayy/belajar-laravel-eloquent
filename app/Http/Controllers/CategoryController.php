<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Database\Seeders\CategorySeeder;
use Illuminate\Database\Eloquent\Model;

class CategoryController extends Controller
{
    public function testInsert()
    {
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

        $result = Category::insert($categories);
        $total = Category::count();
        return response()->json([
            "result" => $result,
            "total" => $total
        ]);
    }

    public function testFind()
    {
        $category = Category::find("FOOD");
        
        return response()->json($category);
    }

    public function testUpdate()
    {
        $category = Category::find("FOOD");
        $category->name = "Food Update";

        $result = $category->update();

        return response()->json($result);
    }

    public function testSelect()
    {
        for ($i = 0; $i < 5; $i++) {
            $category = new Category();
            $category->id = "ID $i";
            $category->name = "Name $i";
            $category->save();
        }

        $categories = Category::whereNull("description")->get();

        return response()->json($categories);   
    }

    public function testUpdateMany()
    {
        $categories = [];
        for ($i = 0; $i < 10; $i++) {
            $categories[] = [
                "id" => "ID $i",
                "name"=> "Name $i",
            ];
        }

        $result = Category::insert($categories);

        Category::whereNull("description")->update([
            "description" => "Updated"
        ]);

        $total = Category::where("description", "Updated")->count();

        return response()->json($total);
    }

    public function testDelete()
    {
        $category = Category::find("FOOD");
        $result = $category->delete();

        $total = Category::count();

        return response()->json([
            "result" => $result,
            "total" => $total
        ]);
    }

    public function testDeleteMany()
    {
        $categories = [];
        for ($i = 0; $i < 10; $i++) {
            $categories[] = [
                "id" => "ID $i",
                "name"=> "Name $i",
            ];
        }

        $result = Category::insert($categories);

        $totalAwal = Category::count();

        Category::whereNull("description")->delete();

        $totalAkhir = Category::count();

        return response()->json([
            "result"=> $result,
            "total_awal"=> $totalAwal,
            "total_akhir" => $totalAkhir
        ]);
    }
}
