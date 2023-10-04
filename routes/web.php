<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\API\Users\BasicDetailsController;
use App\Http\Controllers\API\Users\SignUpController;
use App\Http\Controllers\API\Users\SignInController;
use App\Http\Controllers\API\Activities\HomeActivities;
use App\Http\Controllers\API\Country\CountryList;
use App\Http\Controllers\API\Promotions\PromotionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/token', function (Request $request) {
    $token = $request->session()->token();
    $token = csrf_token();
    return response()->json(['_token' => $token], 200)
            ->header('Content-Type', 'application/json')
            ->header('Access-Control-Allow-Origin', '*');
});

// });

// Route::get('/user/{username}', [BasicDetailsController::class, 'index']);

// require __DIR__.'/auth.php';