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
use App\Http\Controllers\Module\Batchingplant\ReportController;

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

// Route::get('/storage', function () {
//     Artisan::call('storage:link');
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
// Route::group(['prefix' => 'landing-pages'], function () {
//     Route::get('index', [HomeController::class, 'landing_index'])->name('landing-pages.index');
//     Route::get('blog', [HomeController::class, 'landing_blog'])->name('landing-pages.blog');
//     Route::get('blog-detail', [HomeController::class, 'landing_blog_detail'])->name('landing-pages.blog-detail');
//     Route::get('about', [HomeController::class, 'landing_about'])->name('landing-pages.about');
//     Route::get('contact', [HomeController::class, 'landing_contact'])->name('landing-pages.contact');
//     Route::get('ecommerce', [HomeController::class, 'landing_ecommerce'])->name('landing-pages.ecommerce');
//     Route::get('faq', [HomeController::class, 'landing_faq'])->name('landing-pages.faq');
//     Route::get('feature', [HomeController::class, 'landing_feature'])->name('landing-pages.feature');
//     Route::get('pricing', [HomeController::class, 'landing_pricing'])->name('landing-pages.pricing');
//     Route::get('saas', [HomeController::class, 'landing_saas'])->name('landing-pages.saas');
//     Route::get('shop', [HomeController::class, 'landing_shop'])->name('landing-pages.shop');
//     Route::get('shop-detail', [HomeController::class, 'landing_shop_detail'])->name('landing-pages.shop-detail');
//     Route::get('software', [HomeController::class, 'landing_software'])->name('landing-pages.software');
//     Route::get('startup', [HomeController::class, 'landing_startup'])->name('landing-pages.startup');
// });

//UI Pages Routs
// Route::get('/', [HomeController::class, 'uisheet'])->name('uisheet');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/role-permission', [RolePermission::class, 'index'])->name('role.permission.list');
    Route::get('/update-permission', [RolePermission::class, 'store'])->name('role.permission.store');
    Route::resource('permission', PermissionController::class);
    Route::resource('role', RoleController::class);

    // Dashboard Routes
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

    // Users 
    Route::get('update-user-permission', [UserController::class, 'userPermission'])->name('user.permission.update');
    Route::resource('users', UserController::class);

    // Module
    Route::group(['prefix' => 'module'], function () {
        route::get('batchingplant/report', [ReportController::class, 'index'])->name('batchingplant.report.index');
        route::get('batchingplant/jmf', [JmfController::class, 'index'])->name('batchingplant.jmf.index');
        route::get('batchingplant/material-usage', [MaterialUsage::class, 'index'])->name('batchingplant.material_usage.index');
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
