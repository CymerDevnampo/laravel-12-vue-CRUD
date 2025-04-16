<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::controller(PostController::class)->group(function () {
    Route::get('/show/posts', 'showPosts')->name('show.posts');
    Route::get('/create/posts', 'createPosts')->name('create.posts');
    Route::post('/store/posts', 'storePosts')->name('store.posts');
    Route::get('/edit/posts/{id}', 'editPosts')->name('edit.posts');
    Route::post('/update/posts/{id}', 'updatePosts')->name('update.posts');
    Route::post('/delete/posts/{id}', 'deletePosts')->name('delete.posts');
});

// Route::get('/show/posts', [PostController::class, 'showPosts'])->name('show.posts');


require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
