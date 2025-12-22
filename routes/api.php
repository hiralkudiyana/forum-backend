<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\User;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PasswordResetController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\Admin\UserController;
use App\Http\Controllers\Api\Admin\CategoryController;
use App\Http\Controllers\Api\CategoryPublicController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLink']);
Route::post('/reset-password', [PasswordResetController::class, 'reset']);
Route::get('/categories', [CategoryPublicController::class, 'index']);


/*
|--------------------------------------------------------------------------
| Protected User Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/profile', [ProfileController::class, 'show']);
    Route::post('/profile', [ProfileController::class, 'update']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->middleware(['auth:sanctum'])->group(function () {

    Route::get('/dashboard', function () {
        return response()->json(['ok' => true]);
    });

    Route::get('/users', [UserController::class, 'index']);
    
    Route::delete('/users/{id}', [UserController::class, 'destroy']);

    Route::get('/categories', [CategoryController::class, 'index']);
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);

});

/*
|--------------------------------------------------------------------------
| Email Verification
|--------------------------------------------------------------------------
*/

Route::get('/email/verify/{id}/{hash}', function (Request $request, $id, $hash) {

    $user = User::findOrFail($id);

    if (! hash_equals(
        sha1($user->getEmailForVerification()),
        $hash
    )) {
        return response()->json(['message' => 'Invalid verification link'], 403);
    }

    if ($user->hasVerifiedEmail()) {
        return response()->json(['message' => 'Email already verified']);
    }

    $user->markEmailAsVerified();

    return response()->json(['message' => 'Email verified successfully']);

})->middleware('signed')->name('verification.verify');
