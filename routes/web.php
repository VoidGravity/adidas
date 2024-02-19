<?php

use App\Http\Controllers\AuthentificationContoller;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\permissionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\roleController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/product', function () {
//     return view('products.index');
// });
// Route::get('/product/create', function () {
//     return view('products.create');
// });

//new hting to learn : 
// Route::controller(AuthentificationContoller::class)->prefix('/login')->group(function(){
//     Route::get('/',[AuthentificationContoller::class,"login"])->name('auth.login');
//     Route::post('/',[AuthentificationContoller::class,"check"])->name('auth.login');
// });


    Route::get('/', [AuthentificationContoller::class, "index"])->name('index');
    Route::get('/login', [AuthentificationContoller::class, "login"])->name('login');
    Route::post('/login', [AuthentificationContoller::class, "check"])->name('auth.login');
    Route::get('/resetPassword', [AuthentificationContoller::class, "ShowReset"])->name('auth.resetPassword');
    Route::post('/resetPassword', [AuthentificationContoller::class, "ResetPassord"])->name('resetPassword');
    Route::get('/newPassword/{token}', [AuthentificationContoller::class, "showNewPasswordForm"])->name('auth.showNewPasswordForm');
    Route::post('/newPassword', [AuthentificationContoller::class, "newPassword"])->name('auth.newPassword');
    Route::get('/register', [AuthentificationContoller::class, "register"])->name('auth.signin');
    Route::post('/register', [AuthentificationContoller::class, "store"])->name('auth.register');
    Route::delete('/logout', [AuthentificationContoller::class, 'logout'])->name('logout');

Route::group(['middleware' => 'role'], function () {


    //permissions 
    Route::get('/permission', [permissionController::class, 'index'])->name('permission.index');
    Route::get('/permission/create', [permissionController::class, 'create'])->name('permission.showCreate');
    Route::post('/permission/create', [permissionController::class, 'store'])->name('permission.create');
    Route::get('/permission/{id}/edit', [permissionController::class, 'edit'])->name('permission.ShowEdit');
    Route::post('/permission/{id}/edit', [permissionController::class, 'update'])->name('permission.edit');
    Route::get('/permission/{id}/delete', [permissionController::class, 'destroy'])->name('permission.delete');
    //role
    Route::get('/role', [roleController::class, 'index'])->name('role.index');
    Route::get('/role/create', [roleController::class, 'create'])->name('role.showCreate');
    Route::post('/role/create', [roleController::class, 'store'])->name('role.create');
    Route::get('/role/{id}/edit', [roleController::class, 'edit'])->name('role.ShowEdit');
    Route::post('/role/{id}/edit', [roleController::class, 'update'])->name('role.edit');
    Route::get('/role/{id}/delete', [roleController::class, 'destroy'])->name('role.delete');
    //product
    Route::get('/product', [ProductController::class, 'index'])->name('product.index');
    Route::get('/product/create', [ProductController::class, 'create'])->name('product.showCreate');
    Route::post('/product/create', [ProductController::class, 'store'])->name('product.create');
    Route::get('/product/{id}/delete', [ProductController::class, 'destroy'])->name('product.delete');
    Route::get('/product/{id}/edit', [ProductController::class, 'edit'])->name('product.ShowEdit');
    Route::post('/product/{id}/edit', [ProductController::class, 'update'])->name('product.edit');
    Route::post('/filter', [ProductController::class, 'liveFilter'])->name('liveFilter');

    //category
    Route::get('/category', [CategoryController::class, 'index'])->name('category.index');
    Route::get('/category/create', [CategoryController::class, 'create'])->name('category.showCreate');
    Route::post('/category/create', [CategoryController::class, 'store'])->name('category.create');
    Route::get('/category/{id}/delete', [CategoryController::class, 'destroy'])->name('category.delete');
    Route::get('/category/{id}/edit', [CategoryController::class, 'edit'])->name('category.ShowEdit');
    Route::post('/category/{id}/edit', [CategoryController::class, 'update'])->name('category.edit');

    //selles
    Route::get('/sales', [SaleController::class, 'index'])->name('sales.index');
    Route::get('/sales/create', [SaleController::class, 'create'])->name('sale.showCreate');
    Route::post('/sales/create', [SaleController::class, 'store'])->name('sale.create');
    Route::get('/sales/{id}/delete', [SaleController::class, 'destroy'])->name('sales.delete');
    Route::get('/sales/{id}/edit', [SaleController::class, 'edit'])->name('sales.ShowEdit');
    Route::post('/sales/{id}/edit', [SaleController::class, 'update'])->name('sales.edit');
    //clients
    Route::get('/client', [UserController::class, 'index'])->name('client.index');
    //search
    // Route::post('/search', [ProductController::class, 'search'])->name('liveSearch');
    Route::get('/search', [ProductController::class, 'liveSearch'])->name('liveSearch');

    //auth
});
