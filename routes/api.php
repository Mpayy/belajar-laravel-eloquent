<?php

use App\Http\Controllers\CategoryController;
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