<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Backend\HomeController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\Role\RoleController;
use App\Http\Controllers\Backend\User\UserController;

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

Route::get('/', function () {
    return view('Frontend.Home.index');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

Route::prefix('dashboard')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('admin.dashboard');

    ///////////////////// Role Start //////////////////////
    Route::prefix('role')->group(function () {
        Route::get('/', [RoleController::class, 'index'])->name('admin.role.index');
        Route::post('/store', [RoleController::class, 'store'])->name('admin.role.store');
        Route::post('/update/{id}', [RoleController::class, 'update'])->name('admin.role.update');
        Route::post('/update/user/role', [RoleController::class, 'updateUserRole'])->name('admin.role.update.user');
        Route::post('/delete/{id}', [RoleController::class, 'delete'])->name('admin.role.delete');
    });
    ///////////////////// Role End //////////////////////

    ///////////////////// User Start //////////////////////
    Route::prefix('user')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('admin.user.index');
        Route::get('/getAllUsers', [UserController::class, 'getAllUsers'])->name('admin.user.getAllUsers');
        // Route::get('/create', [UserController::class, 'create'])->name('admin.user.create');
        // Route::post('/store', [UserController::class, 'store'])->name('admin.user.store');
        // Route::get('/edit/{id}', [UserController::class, 'edit'])->name('admin.user.edit');
        Route::get('/update/status/{id}', [UserController::class, 'updateStatus'])->name('admin.user.update.status');
        Route::get('/delete/{id}', [UserController::class, 'delete'])->name('admin.user.delete');
    });
    ///////////////////// User End //////////////////////

    ///////////////////// Category Start //////////////////////
    Route::prefix('category')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('admin.category.index');
        Route::get('/create', [CategoryController::class, 'create'])->name('admin.category.create');
        Route::post('/store', [CategoryController::class, 'store'])->name('admin.category.store');
        Route::get('/edit/{id}', [CategoryController::class, 'edit'])->name('admin.category.edit');
        Route::post('/update/{id}', [CategoryController::class, 'update'])->name('admin.category.update');
        Route::post('/delete/{id}', [CategoryController::class, 'destroy'])->name('admin.category.delete');
    });
});


require __DIR__.'/auth.php';
