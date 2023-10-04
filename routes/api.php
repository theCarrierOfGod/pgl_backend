<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Tasks\TasksController;
use App\Http\Controllers\API\Users\SignInController;

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

// ALl Task Route
Route::controller(TasksController::class)->group(function () {
    Route::post('/task/new', "newTask");
    Route::get('/tasks/{username}', "getTasks");
    Route::post('/task/update', "updateTask");
});

// User routes
Route::controller(SignInController::class)->group(function () {
    Route::post('/sign-in', "signIn");
});
