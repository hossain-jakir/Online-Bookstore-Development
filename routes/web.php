<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Backend\TagController;
use App\Http\Controllers\Backend\BookController;
use App\Http\Controllers\Backend\HomeController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\Role\RoleController;
use App\Http\Controllers\Backend\User\UserController;
use App\Http\Controllers\Frontend\WishlistController;
use App\Http\Controllers\Frontend\HomeController as FrontendHomeController;

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

Route::get('/', [FrontendHomeController::class, 'index']);
Route::get('/clear-cache', [FrontendHomeController::class, 'clearCache']);


Route::prefix('wishlist')->middleware(['auth'])->group(function () {
    Route::get('/', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/store', [WishlistController::class, 'store'])->name('wishlist.store');
    Route::post('/delete/{id}', [WishlistController::class, 'delete'])->name('wishlist.delete');
    Route::post('/delete/all', [WishlistController::class, 'deleteAll'])->name('wishlist.delete.all');
});


// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

Route::prefix('dashboard')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('backend.dashboard');

    ///////////////////// Role Start //////////////////////
    Route::prefix('role')->group(function () {
        Route::get('/', [RoleController::class, 'index'])->name('backend.role.index');
        Route::post('/store', [RoleController::class, 'store'])->name('backend.role.store');
        Route::post('/update/{id}', [RoleController::class, 'update'])->name('backend.role.update');
        Route::post('/update/user/role', [RoleController::class, 'updateUserRole'])->name('backend.role.update.user');
        Route::post('/delete/{id}', [RoleController::class, 'delete'])->name('backend.role.delete');
    });
    ///////////////////// Role End //////////////////////

    ///////////////////// User Start //////////////////////
    Route::prefix('user')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('backend.user.index');
        Route::get('/getAllUsers', [UserController::class, 'getAllUsers'])->name('backend.user.getAllUsers');
        // Route::get('/create', [UserController::class, 'create'])->name('backend.user.create');
        // Route::post('/store', [UserController::class, 'store'])->name('backend.user.store');
        // Route::get('/edit/{id}', [UserController::class, 'edit'])->name('backend.user.edit');
        Route::get('/update/status/{id}', [UserController::class, 'updateStatus'])->name('backend.user.update.status');
        Route::get('/delete/{id}', [UserController::class, 'delete'])->name('backend.user.delete');
    });
    ///////////////////// User End //////////////////////

    ///////////////////// Category Start //////////////////////
    Route::prefix('category')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('backend.category.index');
        Route::get('/create', [CategoryController::class, 'create'])->name('backend.category.create');
        Route::post('/store', [CategoryController::class, 'store'])->name('backend.category.store');
        Route::get('/edit/{id}', [CategoryController::class, 'edit'])->name('backend.category.edit');
        Route::post('/update/{id}', [CategoryController::class, 'update'])->name('backend.category.update');
        Route::post('/delete/{id}', [CategoryController::class, 'destroy'])->name('backend.category.delete');
    });

    ///////////////////// Tag Start //////////////////////
    Route::prefix('tag')->group(function () {
        Route::get('/', [TagController::class, 'index'])->name('backend.tag.index');
        Route::get('/create', [TagController::class, 'create'])->name('backend.tag.create');
        Route::post('/store', [TagController::class, 'store'])->name('backend.tag.store');
        Route::get('/edit/{id}', [TagController::class, 'edit'])->name('backend.tag.edit');
        Route::post('/update/{id}', [TagController::class, 'update'])->name('backend.tag.update');
        Route::post('/delete/{id}', [TagController::class, 'destroy'])->name('backend.tag.delete');
    });

    ///////////////////// Tag Start //////////////////////
    Route::prefix('book')->group(function () {
        Route::get('/', [BookController::class, 'index'])->name('backend.book.index');
        Route::get('/create', [BookController::class, 'create'])->name('backend.book.create');
        Route::post('/store', [BookController::class, 'store'])->name('backend.book.store');
        Route::get('/edit/{id}', [BookController::class, 'edit'])->name('backend.book.edit');
        Route::post('/update/{id}', [BookController::class, 'update'])->name('backend.book.update');
        Route::post('/delete/{id}', [BookController::class, 'destroy'])->name('backend.book.delete');
    });
});


require __DIR__.'/auth.php';
