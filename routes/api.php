<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('todo', [TodoController::class, 'index']);
Route::post('add/todo', [TodoController::class, 'store']);
Route::get('show/{id}', [TodoController::class, 'show']);
Route::post('update-task', [TodoController::class, 'update']);
Route::get('complete-Task', [TodoController::class, 'completeTask']);
Route::get('delete/{id}', [TodoController::class, 'destroy']);
Route::get('status/{id}', [TodoController::class, 'status']);

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
