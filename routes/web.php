<?php

use App\Http\Controllers\AboutSectionController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\BlogCategoryController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FooterSectionController;
use App\Http\Controllers\GallerySectionController;
use App\Http\Controllers\HomeSectionController;
use App\Http\Controllers\MenuSectionController;
use App\Http\Controllers\SignatureSectionController;
use App\Http\Controllers\SocialMediaController;
use App\Http\Controllers\TeamImageController;
use App\Http\Controllers\TeamSectionController;
use App\Http\Controllers\TodayMenuSectionController;
use App\Http\Controllers\WebConfigController;
use Illuminate\Support\Facades\Route;


Route::middleware('guest')->group(function ($route) {
  /**
   * Route untuk halaman login dan proses autentikasi pengguna.
   * 
   * @route GET /
   * @description Menampilkan halaman login.
   * @uses AuthController::login
   */
  $route->get('/', [AuthController::class, "login"])->name('login');

  /**
   * Route untuk menangani proses login.
   * 
   * @route POST /auth/login
   * @description Menerima data login dan melakukan autentikasi pengguna.
   * @uses AuthController::authenticate
   */
  $route->post('/auth/login', [AuthController::class, 'authenticate']);
});


Route::middleware('auth')->group(function ($route) {
  $route->prefix('dashboard')->group(function ($route) {
    /**
     * Route untuk menampilkan halaman awal dashboard
     * 
     * @prefix /dashboard/*
     * @description Menampilkan dan menerima data pada prefix route dahsboard.
     * @middleware auth -> yes
     * @uses DashboardController::index
     */
    $route->get('/', [DashboardController::class, 'index']);
    
    $route->patch('about/edit-background', [AboutSectionController::class, 'editBackground']);
    $route->patch('signature/edit-background', [SignatureSectionController::class, 'editBackground']);
    $route->patch('menu/edit-background', [MenuSectionController::class, 'editBackground']);
    $route->patch('footer/edit-background', [FooterSectionController::class, 'editBackground']);
    $route->patch('gallery/edit-background', [GallerySectionController::class, 'editBackground']);

    $route->patch('menu/edit-file', [MenuSectionController::class, 'editFile']);

    $route->get('/home/data', [HomeSectionController::class, 'getData'])->name('home.data');
    $route->get('/gallery/data', [GallerySectionController::class, 'getData'])->name('gallery.data');
    $route->get('/about/data', [AboutSectionController::class, 'getData'])->name('about.data');
    $route->get('/team/data', [TeamSectionController::class, 'getDataImage'])->name('team.image.data');
    $route->get('/team/content/data', [TeamSectionController::class, 'getDataContent'])->name('team.content.data');
    $route->get('/signature/data', [SignatureSectionController::class, 'getData'])->name('signature.data');
    $route->get('/menu/data', [MenuSectionController::class, 'getData'])->name('menu.data');
    $route->get('/today_menu/categories/data', [CategoryController::class, 'getData'])->name('today_menu_categories.data');
    $route->get('/today_menu/data', [TodayMenuSectionController::class, 'getData'])->name('today_menu.data');
    $route->get('/blog/categories/data', [BlogCategoryController::class, 'getData'])->name('blog_categories.data');
    $route->get('/blog/data', [BlogController::class, 'getData'])->name('blog.data');
    $route->get('/social-media/data', [SocialMediaController::class, 'getData'])->name('social_media.data');
    $route->get('/footer/data', [FooterSectionController::class, 'getData'])->name('footer.data');

    $route->resource('home', HomeSectionController::class)->except(['show']);
    $route->resource('gallery', GallerySectionController::class)->except(['show']);
    $route->resource('about', AboutSectionController::class)->except(['show']);
    $route->resource('signature', SignatureSectionController::class)->except(['show']);
    $route->resource('menu', MenuSectionController::class)->except(['show']);
    $route->resource('team', TeamSectionController::class)->except(['show', 'delete']);
    $route->resource('team/image', TeamImageController::class)->except(['index', 'show']);

    $route->resource('today-menu/categories', CategoryController::class)->except(['show']);
    $route->resource('today-menu', TodayMenuSectionController::class)->except(['show']);

    $route->resource('blog/categories', BlogCategoryController::class)->except(['show']);
    $route->resource('blog', BlogController::class)->except(['show']);

    $route->resource('footer', FooterSectionController::class)->except(['show']);

    $route->get('web-config', [WebConfigController::class, 'index']);
    $route->resource('social-media', SocialMediaController::class)->except(['show', 'index']);
  });

  /**
   * Route untuk menangani proses logout.
   * 
   * @route POST /auth/logout
   * @description Menghancurkan session pada aplikasi.
   * @uses AuthController::destroy
   */
  $route->get('/auth/logout', [AuthController::class, 'destroy']);
});