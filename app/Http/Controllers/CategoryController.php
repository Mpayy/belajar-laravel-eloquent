<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Scopes\IsActiveScope;
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

    public function testCreateMassAssignment()
    {
        $request = [
            "id" => "FOOD",
            "name" => "Food",
            "description" => "Food Description"
        ];

        $category = new Category($request);
        $category->save();

        return response()->json([
            "message" => "Success created MassAssignment category",
            "category" => $category
        ]);
    }

    public function testCreateWithQueryBuilder()
    {
        $request = [
            "id" => "FOOD",
            "name" => "Food",
            "description" => "Food Description"
        ];

        $category = Category::create($request);

        return response()->json([
            "message" => "Success created Query Builder category",
            "category" => $category
        ]);
    }

    public function testUpdateMass()
    {
        $request = [
            "name" => "Food Update",
            "description" => "Food Description Update"
        ];

        $category = Category::find("FOOD");
        $category->fill($request);
        $category->save();

        return response()->json([
            "message" => "Success updated MassAssignment category",
            "category" => $category
        ]);
    }

    public function testRemoveGlobalScope()
    {
        $category = new Category();
        $category->id = "FOOD";
        $category->name = "Food";
        $category->description = "Food Category";
        $category->is_active = false;
        $category->save();

        $category = Category::find("FOOD");

        return response()->json($category);
    }

    public function testWithoutGlobalScope()
    {
        $category = new Category();
        $category->id = "FOOD";
        $category->name = "Food";
        $category->description = "Food Category";
        $category->is_active = false;
        $category->save();

        $category = Category::withoutGlobalScope(IsActiveScope::class)->find("FOOD");

        return response()->json($category);
    }

    public function testOneToMany()
    {
        $category = Category::find("FOOD");

        // $product = Product::where("category_id", $category->id)->get();
        $product = $category->products;

        return response()->json([
            "data" => $product
        ]);
    }

    public function testOneToManyQuery()
    {
        $category = new Category();
        $category->id = "FOOD";
        $category->name = "Food";
        $category->description = "Food Category";
        $category->is_active = true;
        $category->save();

        $product = new Product();
        $product->id = "1";
        $product->name = "Product 1";
        $product->description =  "Description 1";

        $category->products()->save($product);

        return response()->json([
            "message"=> "Succes",
            "data"=> $product
        ]);

    }

    public function testRelationQuery()
    {
        $category = Category::find("FOOD");
        // $product = $category->products;
        $outOfStockProduct = $category->products()->where("stock", "<=", 0)->get();

        return response()->json([
            "category"=> $category,
            "out_of_stock_product"=> $outOfStockProduct
        ]);
    }

    public function testHasManyHasOne()
    {
        $category = Category::find("FOOD");
        $cheapestProduct = $category->cheapestProduct;
        $mostExpensivetProduct = $category->mostExpensivetProduct;

        return response()->json([
            "cheapestProduct"=> $cheapestProduct,
            "mostExpensivetProduct"=> $mostExpensivetProduct
        ]);
    }

    public function testHasManyThrough()
    {
        $category = Category::find("FOOD");

        $reviews = $category->reviews;

        return response()->json([
            "category" => $category->name,
            "reviews"=> $reviews
        ]);
    }
}
