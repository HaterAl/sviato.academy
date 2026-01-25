<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CacheController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\ProductsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/cache/clear', [CacheController::class, 'clearCache'])
    ->middleware('verify.api.key')
    ->name('cache.clear');

// Public API endpoints for AJAX requests
Route::get('/events', [EventController::class, 'apiIndex'])
    ->name('api.events.index');

Route::get('/community', [CommunityController::class, 'apiIndex'])
    ->name('api.community.index');

Route::get('/map', [MapController::class, 'apiIndex'])
    ->name('api.map.index');

Route::get('/products', [ProductsController::class, 'apiIndex'])
    ->name('api.products.index');
