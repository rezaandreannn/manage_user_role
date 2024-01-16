<?php

// Controllers
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Security\RoleController;
use App\Http\Controllers\Security\RolePermission;
use App\Http\Controllers\Security\PermissionController;
use App\Http\Controllers\Module\Batchingplant\JmfController;
use App\Http\Controllers\Module\Batchingplant\MaterialUsage;
// Packages

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Module\BatchingPlant\ProduksiController;
use App\Http\Controllers\Module\Batchingplant\ReportController;
use App\Http\Controllers\Module\Batchingplant\BPMaterial;
use App\Models\BatchingPlant;
use Spatie\Permission\Models\Permission;

use App\Http\Controllers\Module\Truckscale\IncomingController;
use App\Http\Controllers\Module\Truckscale\VendorController;
use App\Http\Controllers\Module\Truckscale\MaterialController;

use App\Http\Controllers\Module\Dashboard\MainDashboard;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

require __DIR__ . '/auth.php';

// Route::get('/test', function () {
//     return BatchingPlant::all();
// });


Route::get('/', [AuthenticatedSessionController::class, 'create'])
    ->middleware('guest');

//App Details Page => 'Dashboard'], function() {
Route::group(['prefix' => 'menu-style'], function () {
    //MenuStyle Page Routs
    Route::get('horizontal', [HomeController::class, 'horizontal'])->name('menu-style.horizontal');
    Route::get('dual-horizontal', [HomeController::class, 'dualhorizontal'])->name('menu-style.dualhorizontal');
    Route::get('dual-compact', [HomeController::class, 'dualcompact'])->name('menu-style.dualcompact');
    Route::get('boxed', [HomeController::class, 'boxed'])->name('menu-style.boxed');
    Route::get('boxed-fancy', [HomeController::class, 'boxedfancy'])->name('menu-style.boxedfancy');
});
//Landing-Pages Routes
Route::group(['prefix' => 'MJK'], function () {
    Route::group(['prefix' => 'BP'], function () {
        Route::get('produksi', [ProduksiController::class, 'index'])->name('MJK.BP.produksi');
    });
});

//UI Pages Routs
// Route::get('/', [HomeController::class, 'uisheet'])->name('uisheet');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/role-permission', [RolePermission::class, 'index'])->name('role.permission.list');
    Route::get('/update-permission', [RolePermission::class, 'store'])->name('role.permission.store');
    // Route::get('permission/{permission}/edit/{type}', [PermissionController::class, 'create'])->name('permission.edit');
    Route::resource('permission', PermissionController::class)->except('create');
    Route::get('permission/create/{type}', [PermissionController::class, 'create'])->name('permission.create');
    Route::resource('role', RoleController::class);

    // Dashboard Routes
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

    // Users 
    Route::get('update-user-permission', [UserController::class, 'userPermission'])->name('user.permission.update');
    // Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::resource('users', UserController::class)->parameters([
        'users' => 'uuid',
    ]);

    // Module
    Route::group(['prefix' => 'module'], function () {
        route::get('dashboard/main', [MainDashboard::class, 'index'])->name('dashboard.main.index');


        route::get('batchingplant/docket', [ProduksiController::class, 'index'])->name('batchingplant.docket.index');
        route::get('batchingplant/customer', [ProduksiController::class, 'customer'])->name('batchingplant.customer.index');
        route::get('batchingplant/material', [BPMaterial::class, 'index'])->name('batchingplant.material.index');
        // route::get('batchingplant/report', [ReportController::class, 'index'])->name('batchingplant.report.index');
        // route::get('batchingplant/jmf', [JmfController::class, 'index'])->name('batchingplant.jmf.index');
        // route::get('batchingplant/material-usage', [MaterialUsage::class, 'index'])->name('batchingplant.material_usage.index');

        route::get('truckscale/docket', [IncomingController::class, 'index'])->name('truckscale.docket.index');
        route::get('truckscale/vendor', [VendorController::class, 'index'])->name('truckscale.vendor.index');
        route::get('truckscale/material', [MaterialController::class, 'index'])->name('truckscale.material.index');
        // route::get('truckscale/vendor', [VendorController::class, 'index'])->name('truckscale.vendor.index');
    });
});

//Auth pages Routs
Route::group(['prefix' => 'auth'], function () {
    Route::get('signin', [HomeController::class, 'signin'])->name('auth.signin');
    Route::get('signup', [HomeController::class, 'signup'])->name('auth.signup');
    Route::get('confirmmail', [HomeController::class, 'confirmmail'])->name('auth.confirmmail');
    Route::get('lockscreen', [HomeController::class, 'lockscreen'])->name('auth.lockscreen');
    Route::get('recoverpw', [HomeController::class, 'recoverpw'])->name('auth.recoverpw');
    Route::get('userprivacysetting', [HomeController::class, 'userprivacysetting'])->name('auth.userprivacysetting');
});
