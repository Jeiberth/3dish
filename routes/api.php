<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\DishController;
use App\Http\Controllers\Api\DishGroupController;
use App\Http\Controllers\Api\UserController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', fn (Request $request) => $request->user());
    Route::post('/logout', [AuthController::class, 'logout']);
});


Route::middleware('auth:sanctum')->group(function () {
    // Dish Group Routes
    Route::post('/dish-groups', [DishGroupController::class, 'store'])->name('dish-groups.store');
    Route::get('/dish-groups', [DishGroupController::class, 'index'])->name('dish-groups.index');
    Route::put('/dish-groups/{dishGroup}', [DishGroupController::class, 'update'])->name('dish-groups.update');
    Route::delete('/dish-groups/{dishGroup}', [DishGroupController::class, 'destroy'])->name('dish-groups.destroy');

    // Dish Routes
    Route::post('/dishes', [DishController::class, 'store'])->name('dishes.store');
    Route::put('/dishes/{dish}', [DishController::class, 'update'])->name('dishes.update');
    Route::delete('/dishes/{dish}', [DishController::class, 'destroy'])->name('dishes.destroy');

    // Admin-only Routes
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');

});


/*
elwyn82@example.com
corwin.erwin@example.net+
https://www.registreentreprises.gouv.qc.ca/reqna/gr/gr03/gr03a71.rechercheregistre.mvc/gr03a71?choixdomaine=RegistreEntreprisesQuebec
*/
