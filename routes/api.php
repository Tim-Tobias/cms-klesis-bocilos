<?php

use App\Http\Controllers\Api\FrontendController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::middleware('token.auth')->group(function ($route) {
    $route->get('home-section', [FrontendController::class, 'home']);
    $route->get('about-section', [FrontendController::class, 'about']);
    $route->get('signature-section', [FrontendController::class, 'signature']);
});