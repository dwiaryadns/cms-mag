<?php

use App\Http\Controllers\Corcom\IndexController;
use App\Http\Controllers\Marketing\MarketingController;
use Illuminate\Support\Facades\Auth;
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
    return view('auth.login');
});
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('admin')->middleware(['auth', 'can:isAdmin'])->name('admin.')->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\AdminController::class, 'index'])->name('index');

    Route::prefix('user')->name('user.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('index');
        Route::get('/getUser', [App\Http\Controllers\Admin\UserController::class, 'getUser'])->name('getUser');
        Route::post('/store', [App\Http\Controllers\Admin\UserController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [App\Http\Controllers\Admin\UserController::class, 'edit'])->name('edit');
        Route::delete('/{id}/delete', [App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('delete');
    });
    Route::prefix('faq')->name('faq.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\FaqController::class, 'index'])->name('index');
        Route::get('/getFaq', [App\Http\Controllers\Admin\FaqController::class, 'getFaq'])->name('getFaq');
        Route::post('/store', [App\Http\Controllers\Admin\FaqController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [App\Http\Controllers\Admin\FaqController::class, 'edit'])->name('edit');
        Route::delete('/{id}/delete', [App\Http\Controllers\Admin\FaqController::class, 'destroy'])->name('delete');
    });
    Route::prefix('list-branches')->name('list-branches.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\ListBranchesController::class, 'index'])->name('index');
        Route::get('/getListBranches', [App\Http\Controllers\Admin\ListBranchesController::class, 'getListBranches'])->name('getListBranches');
        Route::post('/store', [App\Http\Controllers\Admin\ListBranchesController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [App\Http\Controllers\Admin\ListBranchesController::class, 'edit'])->name('edit');
        Route::delete('/{id}/delete', [App\Http\Controllers\Admin\ListBranchesController::class, 'destroy'])->name('delete');
    });
    Route::prefix('promotion')->name('promotion.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\PromotionController::class, 'index'])->name('index');
        Route::get('/getPromotion', [App\Http\Controllers\Admin\PromotionController::class, 'getPromotion'])->name('getPromotion');
        Route::post('/store', [App\Http\Controllers\Admin\PromotionController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [App\Http\Controllers\Admin\PromotionController::class, 'edit'])->name('edit');
        Route::delete('/{id}/delete', [App\Http\Controllers\Admin\PromotionController::class, 'destroy'])->name('delete');
    });
    Route::prefix('terms')->name('terms.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\TermsController::class, 'index'])->name('index');
        Route::get('/getTerms', [App\Http\Controllers\Admin\TermsController::class, 'getTerms'])->name('getTerms');
        Route::post('/store', [App\Http\Controllers\Admin\TermsController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [App\Http\Controllers\Admin\TermsController::class, 'edit'])->name('edit');
        Route::delete('/{id}/delete', [App\Http\Controllers\Admin\TermsController::class, 'destroy'])->name('delete');
    });
    Route::prefix('news')->name('news.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\NewsController::class, 'index'])->name('index');
        Route::get('/getNews', [App\Http\Controllers\Admin\NewsController::class, 'getNews'])->name('getNews');
        Route::post('/store', [App\Http\Controllers\Admin\NewsController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [App\Http\Controllers\Admin\NewsController::class, 'edit'])->name('edit');
        Route::delete('/{id}/delete', [App\Http\Controllers\Admin\NewsController::class, 'destroy'])->name('delete');
    });
});
Route::prefix('marketing')->middleware(['auth', 'can:isMarketing'])->name('marketing.')->group(function () {
    Route::get('/', [App\Http\Controllers\Marketing\MarketingController::class, 'index'])->name('index');
});
Route::prefix('user')->middleware(['auth', 'can:isUser'])->name('user.')->group(function () {
    Route::get('/', [App\Http\Controllers\User\UserController::class, 'index'])->name('index');
});