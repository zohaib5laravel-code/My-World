<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\PictureController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;



Route::middleware('auth')->prefix('admin')->group(function () {

    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    //pictures
    Route::get('pictures', [PictureController::class, 'index'])->name('pictures.index');
    Route::get('pictures/create', [PictureController::class, 'create'])->name('pictures.create');
    Route::post('pictures/store', [PictureController::class, 'store'])->name('pictures.store');
    Route::get('pictures/{id}', [PictureController::class, 'show'])->name('pictures.show');
    Route::get('pictures/{id}/edit', [PictureController::class, 'edit'])->name('pictures.edit');
    Route::patch('pictures/{id}/update', [PictureController::class, 'update'])->name('pictures.update');
    Route::delete('pictures/delete/{id}', [PictureController::class, 'delete'])->name('pictures.delete');
   
    //categories
    Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('categories/store', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('categories/{id}', [CategoryController::class, 'show'])->name('categories.show');
    Route::get('categories/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::patch('categories/{id}/update', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('categories/delete/{id}', [CategoryController::class, 'delete'])->name('categories.delete');

    //posts
    Route::get('posts', [PostController::class, 'index'])->name('posts.index');
    Route::get('posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('posts/store', [PostController::class, 'store'])->name('posts.store');
    Route::get('posts/{id}', [PostController::class, 'show'])->name('posts.show');
    Route::get('posts/{id}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::patch('posts/{id}/update', [PostController::class, 'update'])->name('posts.update');
    Route::delete('posts/delete/{id}', [PostController::class, 'delete'])->name('posts.delete');




});

require __DIR__.'/auth.php';



Route::get('/', [FrontendController::class, 'index'])->name('frontend.home');
Route::get('/gallery', [FrontendController::class, 'gallery'])->name('frontend.gallery');
Route::get('/about', [FrontendController::class, 'about'])->name('frontend.about');
Route::get('/contact', [FrontendController::class, 'contact'])->name('frontend.contact');
Route::post('/contact/send', [FrontendController::class, 'sendMessage'])->name('contact.send');
Route::get('/posts', [FrontendController::class, 'posts'])->name('frontend.posts');
Route::get('/{slug}', [FrontendController::class, 'post'])->name('frontend.post');
Route::post('/{post}/comment', [FrontendController::class, 'storeComment'])->name('frontend.comment.store');
