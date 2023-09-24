<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AppController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DocImageController;
use App\Http\Controllers\DocTypeController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UserController;
use App\Models\DocImage;
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

Route::get('ping', fn () => "pong");
Route::post('migrate', [AppController::class, 'migrate']);
Route::put('migrate', [AppController::class, 'migrate_fresh']);

Route::get('admin/user', [AdminController::class, 'index'])->name('admin.index');
Route::post('admin/login', [AdminController::class, 'login'])->name('admin.login');

Route::post('login', [ProfileController::class, 'apiLogin']);
Route::get('me', [ProfileController::class, 'me'])->middleware(['auth:api']);

Route::apiResource('user', UserController::class)->middleware(['auth:api']);
Route::apiResource('search', SearchController::class)->middleware(['auth:api']);
Route::apiResource('type', DocTypeController::class)->middleware(['auth:api']);
Route::apiResource('department', DepartmentController::class)->middleware(['auth:api']);
Route::apiResource('document', DocumentController::class)->middleware(['auth:api']);
Route::apiResource('image', DocImageController::class); //->middleware(['auth:api']);
Route::post('image/multiple', [DocImageController::class, 'multiple']);
