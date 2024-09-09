<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\Api\AdminController;

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


Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');

});
Route::group(['middleware' => ['admin']], function () {
    Route::apiResource('tasks', TaskController::class);
    Route::apiResource('users', AdminController::class);
    
});
Route::group(['middleware' => ['manager']], function () {

    Route::get('tasks', [TaskController::class, 'index']);
    Route::post('tasks', [TaskController::class, 'store']);
    Route::put('tasks/{task}', [TaskController::class, 'update']);
    Route::delete('tasks/{task}', [TaskController::class, 'destroy']);
});
Route::group(['middleware' => ['user']], function () {
    Route::get('tasks/{task}', [TaskController::class, 'showTask']);
    Route::get('tasks/{task}', [TaskController::class, 'update_assigned_to']);
});
Route::apiResource('tasks', TaskController::class);