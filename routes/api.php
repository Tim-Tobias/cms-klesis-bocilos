<?php

use App\Http\Controllers\Api\FrontendController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::middleware('token.auth')->group(function ($route) {
    $route->get('home-section', [FrontendController::class, 'home']);
    $route->get('gallery-section', [FrontendController::class, 'gallery']);
    $route->get('about-section', [FrontendController::class, 'about']);
    $route->get('signature-section', [FrontendController::class, 'signature']);
    $route->get('menu-section', [FrontendController::class, 'menu']);
    $route->get('team-section', [FrontendController::class, 'team']);
    $route->get('categories', [FrontendController::class, 'categories']);
    $route->get('/today-menu', [FrontendController::class, 'todayMenu']);
    $route->get('/footer-section', [FrontendController::class, 'footer']);
    $route->get('/blog-categories', [FrontendController::class, 'blogCategories']);
    $route->get('/blogs', [FrontendController::class, 'blog']);
    $route->get('/blogs/{id}', [FrontendController::class, 'blogDetail']);
    $route->get('/social-media', [FrontendController::class, 'socialMedia']);
});