<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Middleware\CheckRole;



Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::middleware('auth:api')->get('user', [AuthController::class, 'user']);
Route::middleware('auth:api')->post('logout', [AuthController::class, 'logout
']);



// Route accessible uniquement par le Super Admin
Route::middleware(['auth:api', CheckRole::class . ':super_admin'])->post('create-user', [UserController::class, 'createUser']);

// Route accessible uniquement par l'Admin
Route::middleware(['auth:api', CheckRole::class . ':admin'])->post('update-user', [UserController::class, 'updateUser']);

// Route pour récupérer les informations de l'utilisateur authentifié
Route::middleware('auth:api')->get('user', [AuthController::class, 'user']);

// Routes publiques
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

Route::middleware('auth:api')->group(function () {
    // Toutes les routes ici nécessitent une authentification
    Route::post('create-user', [UserController::class, 'createUser']);
    Route::post('update-user', [UserController::class, 'updateUser']);
});

Route::middleware('auth:api')->get('/users', [AuthController::class,  'getAllUsers']);

/*/lkkkd
