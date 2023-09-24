<?php

use App\Http\Controllers\DocImageController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DocTypeController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', fn () => view('app'));
Route::post('/login', [ProfileController::class, 'login']);
Route::get('/me', [ProfileController::class, 'me'])->middleware(['auth:web']);
Route::post('/logout', [ProfileController::class, 'logout'])->middleware(['auth:web']);

Route::apiResource('group', GroupController::class);
Route::apiResource('user', UserController::class);
Route::apiResource('search', SearchController::class);
Route::apiResource('type', DocTypeController::class);
Route::apiResource('department', DepartmentController::class);
Route::apiResource('image', DocImageController::class);

Route::post('document/search', [DocumentController::class, 'search']);
Route::get('document/search', [DocumentController::class, 'search'])->middleware(['auth:web']);
Route::get('document/{document}/download', [DocumentController::class, 'download']);
