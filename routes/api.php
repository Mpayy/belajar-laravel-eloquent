<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
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

Route::get('vouchers/testCreateVoucher', [VoucherController::class, "testCreateVoucher"]);
Route::get('vouchers/testVoucherUUID', [VoucherController::class, "testVoucherUUID"]);
Route::get('vouchers/testSoftDelete', [VoucherController::class, "testSoftDelete"]);
Route::get('vouchers/testSoftDeleteWithTrashed', [VoucherController::class, "testSoftDeleteWithTrashed"]);
Route::get('vouchers/testLocalScope', [VoucherController::class, "testLocalScope"]);

Route::get('comments/testCreateComment', [CommentController::class, "testCreateComment"]);
Route::get('comments/testDefaultAttributesValues', [CommentController::class, "testDefaultAttributesValues"]);