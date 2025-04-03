<?php

use App\Http\Controllers\AboutSectionController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HomeSectionController;
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

    $route->resource('home', HomeSectionController::class);
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