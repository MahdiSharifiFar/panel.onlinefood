<?php


use App\Http\Controllers\AboutController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\FeatureController;
use App\Http\Controllers\FooterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    Route::get('/', [HomeController::class, 'index'])->name('panel.home');

    Route::group(['prefix' => 'about'], function () {
        Route::get('/', [AboutController::class, 'index'])->name('about.index');
        Route::get('/edit/{about}', [AboutController::class, 'edit'])->name('about.edit');

        Route::put('/update/{about}', [AboutController::class, 'update'])->name('about.update');
    });

    Route::group(['prefix' => 'footer'], function () {
        Route::get('/', [FooterController::class, 'index'])->name('footer.index');
        Route::get('/edit/{footer}', [FooterController::class, 'edit'])->name('footer.edit');

        Route::put('/update/{footer}', [FooterController::class, 'update'])->name('footer.update');
    });

    Route::group(['prefix' => 'contact'], function () {
        Route::get('/', [ContactUsController::class, 'index'])->name('contact.index');
        Route::delete('/delete/{contact}', [ContactUsController::class, 'delete'])->name('contact.delete');


    });

    Route::group(['prefix' => 'slider'], function () {

        Route::get('/', [SliderController::class, 'index'])->name('slider.index');

        Route::get('/create', [SliderController::class, 'create'])->name('slider.create');
        Route::post('/store', [SliderController::class, 'store'])->name('slider.store');

        Route::get('/edit/{slider}', [SliderController::class, 'edit'])->name('slider.edit');
        Route::put('/update/{slider}', [SliderController::class, 'update'])->name('slider.update');
        Route::delete('/destroy/{slider}', [SliderController::class, 'destroy'])->name('slider.destroy');
    });

    Route::group(['prefix' => 'users' , 'middleware' => 'can:admin'], function () {
        Route::get('/', [UserController::class, 'index'])->name('users.index');

        Route::get('/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/store', [UserController::class, 'store'])->name('users.store');

        Route::get('/edit/{user}', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/update/{user}', [UserController::class, 'update'])->name('users.update');

    });

    Route::group(['prefix' => 'roles'], function () {
        Route::get('/', [RoleController::class, 'index'])->name('roles.index');

        Route::get('/create', [RoleController::class, 'create'])->name('roles.create');
        Route::post('/store', [RoleController::class, 'store'])->name('roles.store');

        Route::get('/edit/{role}', [RoleController::class, 'edit'])->name('roles.edit');
        Route::put('/update/{role}', [RoleController::class, 'update'])->name('roles.update');

    });

    Route::group(['prefix' => 'feature'], function () {
        Route::get('/', [FeatureController::class, 'index'])->name('feature.index');

        Route::get('/create', [FeatureController::class, 'create'])->name('feature.create');
        Route::post('/store', [FeatureController::class, 'store'])->name('feature.store');

        Route::get('/edit/{feature}', [FeatureController::class, 'edit'])->name('feature.edit');
        Route::put('/update/{feature}', [FeatureController::class, 'update'])->name('feature.update');
        Route::delete('/destroy/{feature}', [FeatureController::class, 'destroy'])->name('feature.destroy');

    });

    Route::group(['prefix' => 'categories'], function () {
        Route::get('/', [CategoryController::class, 'index'])->name('category.index');

        Route::get('/create', [CategoryController::class, 'create'])->name('category.create');
        Route::post('/store', [CategoryController::class, 'store'])->name('category.store');

        Route::get('/edit/{category}', [CategoryController::class, 'edit'])->name('category.edit');
        Route::put('/update/{category}', [CategoryController::class, 'update'])->name('category.update');

        Route::delete('/destroy/{category}', [CategoryController::class, 'destroy'])->name('category.destroy');

    });

    Route::group(['prefix' => 'products'], function () {
        Route::get('/', [ProductController::class, 'index'])->name('product.index');

        Route::get('/create', [ProductController::class, 'create'])->name('product.create');
        Route::post('/store', [ProductController::class, 'store'])->name('product.store');

        Route::get('/edit/{product}', [ProductController::class, 'edit'])->name('product.edit');
        Route::put('/update/{product}', [ProductController::class, 'update'])->name('product.update');

        Route::delete('/destroy/{product}', [ProductController::class, 'destroy'])->name('product.destroy');

        Route::get('/show/{product}', [ProductController::class, 'show'])->name('product.show');

    });

    Route::group(['prefix' => 'coupons'], function () {
        Route::get('/', [CouponController::class, 'index'])->name('coupon.index');

        Route::get('/create', [CouponController::class, 'create'])->name('coupon.create');
        Route::post('/store', [CouponController::class, 'store'])->name('coupon.store');

        Route::get('/edit/{coupon}', [CouponController::class, 'edit'])->name('coupon.edit');
        Route::put('/update/{coupon}', [CouponController::class, 'update'])->name('coupon.update');

        Route::delete('/destroy/{coupon}', [CouponController::class, 'destroy'])->name('coupon.destroy');

        Route::get('/show/{coupon}', [CouponController::class, 'show'])->name('coupon.show');

    });

    Route::group(['prefix' => 'orders'], function () {
        Route::get('/', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/sent/{order}', [OrderController::class, 'sent'])->name('orders.sent');
        Route::get('/cancel/{order}', [OrderController::class, 'cancel'])->name('orders.cancel');
        Route::get('/return/{order}', [OrderController::class, 'return'])->name('orders.return');
    });

    Route::group(['prefix' => 'transactions'], function () {
        Route::get('/', [TransactionController::class, 'index'])->name('transactions.index');
    });

    Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');

});

Route::group(['prefix' => 'auth'], function () {
    Route::get('/login', [AuthController::class, 'index'])->name('auth.index');
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
});



