<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\VoucherController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;





Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/', function(){
    return response()->json(['message'=>'API has Run !!', 'version' => '1.0']);
});

Route::get('categories/testInsert',[CategoryController::class,'testInsert']);
Route::get('categories/testInsertMany',[CategoryController::class,'testInsertMany']);
Route::get('categories/testFind',[CategoryController::class,'testFind']);
Route::get('categories/testUpdate',[CategoryController::class,'testUpdate']);
Route::get('categories/testSelect',[CategoryController::class,'testSelect']);
Route::get('categories/testUpdateMany',[CategoryController::class,'testUpdateMany']);
Route::get('categories/testDelete',[CategoryController::class,'testDelete']);
Route::get('categories/testDeleteMany',[CategoryController::class,'testDeleteMany']);
Route::get('categories/testCreateMassAssignment',[CategoryController::class,'testCreateMassAssignment']);
Route::get('categories/testCreateWithQueryBuilder',[CategoryController::class,'testCreateWithQueryBuilder']);
Route::get('categories/testUpdateMass',[CategoryController::class,'testUpdateMass']);
Route::get('categories/testRemoveGlobalScope',[CategoryController::class,'testRemoveGlobalScope']);
Route::get('categories/testWithoutGlobalScope',[CategoryController::class,'testWithoutGlobalScope']);
Route::get('categories/testOneToMany',[CategoryController::class,'testOneToMany']);
Route::get('categories/testOneToManyQuery',[CategoryController::class,'testOneToManyQuery']);
Route::get('categories/testRelationQuery',[CategoryController::class,'testRelationQuery']);
Route::get('categories/testHasManyHasOne',[CategoryController::class,'testHasManyHasOne']);
Route::get('categories/testHasManyThrough',[CategoryController::class,'testHasManyThrough']);
Route::get('categories/testQueryingRelations',[CategoryController::class,'testQueryingRelations']);
Route::get('categories/testAggregationsRelations',[CategoryController::class,'testAggregationsRelations']);

Route::get('vouchers/testCreateVoucher', [VoucherController::class, "testCreateVoucher"]);
Route::get('vouchers/testVoucherUUID', [VoucherController::class, "testVoucherUUID"]);
Route::get('vouchers/testSoftDelete', [VoucherController::class, "testSoftDelete"]);
Route::get('vouchers/testSoftDeleteWithTrashed', [VoucherController::class, "testSoftDeleteWithTrashed"]);
Route::get('vouchers/testLocalScope', [VoucherController::class, "testLocalScope"]);

Route::get('comments/testCreateComment', [CommentController::class, "testCreateComment"]);
Route::get('comments/testDefaultAttributesValues', [CommentController::class, "testDefaultAttributesValues"]);

Route::get('customers/testQueryOneToOne', [CustomerController::class, "testQueryOneToOne"]);
Route::get('customers/testInsertRelationship', [CustomerController::class, "testInsertRelationship"]);
Route::get('customers/testHasOneThrough', [CustomerController::class, "testHasOneThrough"]);
Route::get('customers/testManyToMany', [CustomerController::class, "testManyToMany"]);
Route::get('customers/testManyToManyDetach', [CustomerController::class, "testManyToManyDetach"]);
Route::get('customers/testPivotAtribute', [CustomerController::class, "testPivotAtribute"]);
Route::get('customers/testPivotAttributeCondition', [CustomerController::class, "testPivotAttributeCondition"]);
Route::get('customers/testPivotModel', [CustomerController::class, "testPivotModel"]);
Route::get('customers/testOneToOnePolymorphic', [CustomerController::class, "testOneToOnePolymorphic"]);
Route::get('customers/testEager', [CustomerController::class, "testEager"]);
Route::get('customers/testEagerModel', [CustomerController::class, "testEagerModel"]);

Route::get('products/testOneToMany', [ProductController::class, "testOneToMany"]);
Route::get('products/testOneToOnePolymorphicProduct', [ProductController::class, "testOneToOnePolymorphicProduct"]);
Route::get('products/testOneToManyPolymorphic', [ProductController::class, "testOneToManyPolymorphic"]);
Route::get('products/testOneOfManyPolymorphic', [ProductController::class, "testOneOfManyPolymorphic"]);
Route::get('products/testManyToManyPolymorphic', [ProductController::class, "testManyToManyPolymorphic"]);
Route::get('products/testEloquentCollection', [ProductController::class, "testEloquentCollection"]);
Route::get('products/testSerializationRelation', [ProductController::class, "testSerializationRelation"]);

Route::get('persons/testAccessorsMutators', [PersonController::class, "testAccessorsMutators"]);
Route::get('persons/testAttributeCasting', [PersonController::class, "testAttributeCasting"]);
Route::get('persons/testCustomCast', [PersonController::class, "testCustomCast"]);

Route::get('employees/testFactory', [EmployeeController::class, "testFactory"]);
