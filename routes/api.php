<?php

use App\Http\Controllers\Api\AboutController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\EmailVerificationController;
use App\Http\Controllers\Api\PostController;
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
// Post Register api route
Route::post('/auth/register', [AuthController::class, 'register']);

// Post Login api route
Route::post('/auth/login', [AuthController::class, 'login']);


// protected api route
Route::get('auth/user', [AuthController::class, 'user'])->middleware('auth:sanctum');

// protected logout api route
Route::post('auth/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// Get users
Route::get('/user', [AuthController::class, 'index'])->middleware('auth:sanctum');


// email verification Notification
Route::post('email/Verification-Notification', [EmailVerificationController::class, 'SendVerificationEmail'])->middleware('auth:sanctum');


// email verification Verify
Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])->middleware('auth:sanctum');


//   Verified User
Route::get('/verified-user', function () {
    return response()->json([
        'message' => 'the email account is already confirmed now you are able to see this message...',
    ]);
})->middleware('auth:sanctum', 'verified');


// Posts api route
Route::apiResource('/post', PostController::class)->middleware('auth:sanctum');

// About api route
Route::get('/about', [AboutController::class, 'index'])->middleware('auth:sanctum');
Route::post('/about/store', [AboutController::class, 'store'])->middleware('auth:sanctum');
Route::put('/about/update/{id}', [AboutController::class, 'update'])->middleware('auth:sanctum');
Route::delete('/about/delete/{id}', [AboutController::class, 'destroy'])->middleware('auth:sanctum');
