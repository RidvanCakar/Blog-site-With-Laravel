<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Log;

// Anasayfa
Route::get('/', function () {
    return view('anasayfa');
});

// Kullanıcı Girişi ve Kayıt İşlemleri
Route::get('/register', [AuthController::class, 'showRegisterForm']);
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');

// Admin işlemleri için route'lar
Route::middleware(['auth', 'admin'])->group(function () {
    // Post işlemleri
    Route::get('/post/create', [PostController::class, 'create'])->name('post.create');
    Route::post('/post/store', [PostController::class, 'store'])->name('post.store');
    Route::get('/post/edit/{id}', [PostController::class, 'edit'])->name('post.edit');
    Route::post('/post/update/{id}', [PostController::class, 'update'])->name('post.update');
    Route::delete('/post/delete/{id}', [PostController::class, 'destroy'])->name('post.delete');
    
    // Yorum silme işlemi (admin)
    Route::delete('/comment/{id}', [CommentController::class, 'destroy'])->name('comment.delete');
});

// Yorum ekleme işlemi (giriş yapmış kullanıcılar için)
Route::middleware(['auth'])->group(function () {
    Route::post('/post/{id}/comment', [CommentController::class, 'store']);
});

// Postları listeleme ve tek post gösterme
Route::get('/posts', [PostController::class, 'index'])->name('post.index');
Route::get('/post/{id}', [PostController::class, 'show'])->name('post.show');

// Log test route'u (geliştirme için)
Route::get('/log-test', [\App\Http\Controllers\PostController::class, 'logTest']);
