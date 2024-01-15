<?php

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
Route::get('/', function () {
    return redirect('login');
});

//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->middleware(['auth', 'verified'])->name('dashboard');
//
//Route::middleware('auth')->group(function () {
//    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
//});

require __DIR__.'/auth.php';
//Route::get('/', function () {
//    return view('welcome');
//});
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::group(['prefix' => 'laravel-filemanager'], function () {
        \UniSharp\LaravelFilemanager\Lfm::routes();
    });
//Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Admin\AdminDashboardController::class, 'dashboard'])->name('admin.dashboard');
//    Route::get('/dashboard', [\App\Http\Controllers\Admin\AdminDashboardController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/profile/edit', [\App\Http\Controllers\Admin\AdminProfileController::class, 'edit'])->name('admin.profile.edit');
    Route::patch('/profile', [\App\Http\Controllers\Admin\AdminProfileController::class, 'update'])->name('admin.profile.update');
    Route::get('/profile/reset-password', [\App\Http\Controllers\Admin\AdminProfileController::class, 'resetPassword'])->name('admin.profile.reset_password');

    Route::prefix('users')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('admin.users.index');
        Route::get('/datatable', [\App\Http\Controllers\Admin\UserController::class, 'datatable'])->name('admin.users.datatable');
        Route::post('/', [\App\Http\Controllers\Admin\AdminUsersController::class, 'store'])->name('admin.users.store');
        Route::get('/{id}/edit', [\App\Http\Controllers\Admin\AdminUsersController::class, 'edit'])->name('admin.users.edit');
        Route::get('/create', [\App\Http\Controllers\Admin\AdminUsersController::class, 'create'])->name('admin.users.create');
        Route::delete('/{id}', [\App\Http\Controllers\Admin\AdminUsersController::class, 'destroy'])->name('admin.users.destroy');
        Route::post('/{id}/toggle-approve', [\App\Http\Controllers\Admin\AdminUsersController::class, 'toggleApprove'])->name('admin.users.toggle_approve');
        Route::patch('/{id}/update', [\App\Http\Controllers\Admin\AdminUsersController::class, 'update'])->name('admin.users.update');
    });
    Route::prefix('categories')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\CategoryController::class, 'index'])->name('admin.categories.index');
        Route::get('/datatable', [\App\Http\Controllers\Admin\CategoryController::class, 'datatable'])->name('admin.categories.datatable');
        Route::post('/', [\App\Http\Controllers\Admin\CategoryController::class, 'store'])->name('admin.categories.store');
        Route::get('/create', [\App\Http\Controllers\Admin\CategoryController::class, 'create'])->name('admin.categories.create');
        Route::get('/{id}', [\App\Http\Controllers\Admin\CategoryController::class, 'edit'])->name('admin.categories.edit');
        Route::patch('/{id}/update', [\App\Http\Controllers\Admin\CategoryController::class, 'update'])->name('admin.categories.update');
        Route::delete('/{id}', [\App\Http\Controllers\Admin\CategoryController::class, 'delete'])->name('admin.categories.delete');
    });

    Route::prefix('products')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\ProductController::class, 'index'])->name('admin.products.index');
        Route::get('/datatable', [\App\Http\Controllers\Admin\ProductController::class, 'datatable'])->name('admin.products.datatable');
        Route::get('/create', [\App\Http\Controllers\Admin\ProductController::class, 'create'])->name('admin.products.create');
        Route::post('/store', [\App\Http\Controllers\Admin\ProductController::class, 'store'])->name('admin.products.store');
        Route::get('/{id}/edit', [\App\Http\Controllers\Admin\ProductController::class, 'edit'])->name('admin.products.edit');
        Route::post('/update', [\App\Http\Controllers\Admin\ProductController::class, 'update'])->name('admin.products.update');
        Route::get('/products/{id}/assign-add-ons', [\App\Http\Controllers\Admin\ProductController::class, 'assingAdOnToProductPage'])->name('admin.products.assign-add-on');
    });

    Route::prefix('addons')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\ProductAdOnsController::class, 'index'])->name('admin.addons.index');
        Route::get('/datatable', [\App\Http\Controllers\Admin\ProductAdOnsController::class, 'datatable'])->name('admin.addons.datatable');
        Route::get('/create', [\App\Http\Controllers\Admin\ProductAdOnsController::class, 'create'])->name('admin.addons.create');
        Route::post('/store', [\App\Http\Controllers\Admin\ProductAdOnsController::class, 'store'])->name('admin.addons.store');
        Route::get('/{id}/edit', [\App\Http\Controllers\Admin\ProductAdOnsController::class, 'edit'])->name('admin.addons.edit');
        Route::post('/update', [\App\Http\Controllers\Admin\ProductAdOnsController::class, 'update'])->name('admin.addons.update');
        Route::get('/assign-values', [\App\Http\Controllers\Admin\ProductAdOnsController::class, 'assignValues'])->name('admin.addons.assign-values');
        Route::post('/assign-values-store', [\App\Http\Controllers\Admin\ProductAdOnsController::class, 'storeProductAdOns'])->name('admin.addons.assign-values-store');
    });
});
