<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('tasks', 'App\Http\Controllers\ApiTaskController@getAllTasks');
Route::post('tasks', 'App\Http\Controllers\ApiTaskController@createTask');
Route::put('tasks/{id}', 'App\Http\Controllers\ApiTaskController@updateTask');
Route::put('tasks', 'App\Http\Controllers\ApiTaskController@updateTasksOrder');
Route::delete('tasks/{id}','App\Http\Controllers\ApiTaskController@deleteTask');