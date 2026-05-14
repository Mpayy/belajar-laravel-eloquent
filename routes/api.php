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