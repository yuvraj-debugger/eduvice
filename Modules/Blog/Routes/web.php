<?php
use Illuminate\Support\Facades\Route;
use Modules\Blog\Http\Controllers\BlogController;
use Modules\Blog\Http\Controllers\TagController;
/*
 * |--------------------------------------------------------------------------
 * | Web Routes
 * |--------------------------------------------------------------------------
 * |
 * | Here is where you can register web routes for your application. These
 * | routes are loaded by the RouteServiceProvider within a group which
 * | contains the "web" middleware group. Now create something great!
 * |
 */

Route::prefix('blog')->group(function () {
    Route::get('/', [
        BlogController::class,
        'posts'
    ])->name('blog.posts');
    
    Route::get('/tags', [
        TagController::class,
        'index'
    ])->name('blog.tags');
    
    Route::get('/tags/create', [
        TagController::class,
        'create'
    ])->name('blog.tags.create');
    
    Route::get('/category', [
        BlogController::class,
        'category'
    ])->name('blog.category');
});
