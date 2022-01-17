<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(["prefix" => "admin", "middleware" => ["auth", "verified"]], function () {
    Route::get("", [DashboardController::class, "index"])->name("dashboard");
    Route::put("/role/{role}/perm", [RoleController::class, "perm"])->name("role.perm");
    Route::resource("/role", RoleController::class)->only("index", "edit");
    Route::put('/user/{user}/restore', [UserController::class, 'restore'])->name("user.restore");
    Route::resource("/user", UserController::class);
});
require __DIR__ . '/auth.php';
