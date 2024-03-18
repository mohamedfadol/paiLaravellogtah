<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaxController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SubscritionController;

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
Route::group(['prefix' => LaravelLocalization::setLocale()], function()
{
Route::get('/', function () {
    return view('welcome');
});

});
Route::get('tesing',  function () {
    // dd(auth()->user()->can('new_tax'));
    return 'yrs';

});
Route::get('/index', function () {
    // Artisan::call('route:cache');
    // Artisan::call('view:cache');
    //     Artisan::call('config:cache');
    //         Artisan::call('cache:clear');
    //         Artisan::call('optimize:clear');

    return view('index');

});
// Route::get('/{page}', 'App\Http\Controllers\AdminController@index');


    Route::get('/business/register', [BusinessController::class, 'getRegister'])->name('business.getRegister');
    Route::post('/business/register', [BusinessController::class, 'postRegister'])->name('business.postRegister');
    Route::post('/business/register/check-username', [BusinessController::class, 'postCheckUsername'])->name('business.postCheckUsername');
    Route::post('/business/register/check-email', [BusinessController::class, 'postCheckEmail'])->name('business.postCheckEmail');


Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ,'auth', 'verified','SetSessionData', 'language', 'timezone', 'CheckUserLogin']
    ], function(){ //...
        //
        //Routes for authenticated users only
    Route::get('/clear-cache', function() {
    Artisan::call('config:cache');
        Artisan::call('cache:clear');
        Artisan::call('optimize:clear');
        return "Cache is cleared";
    });

        Route::get('dashboard', [DashboardController::class,'index'])->name('dashboard');
        Route::resource('/dashboard', DashboardController::class);

        Route::resource('/subscritions', SubscritionController::class);

        Route::get('/get-list-packages', [PackageController::class,'getListPackages'])->name('get.packages.list');
        Route::post('/getPackageDetails',[PackageController::class, 'getPackageDetails'])->name('get.package.details');
        Route::post('/updatePackageDetails',[PackageController::class, 'updatePackageDetails'])->name('update.package.details');
        Route::post('/deletePackage',[PackageController::class,'deletePackage'])->name('delete.package');
        Route::post('/deleteSelectedPackages',[PackageController::class,'deleteSelectedPackages'])->name('delete.selected.packages');
        Route::resource('/packages', PackageController::class);

        Route::get('/get-list-taxs', [TaxController::class,'getListTaxs'])->name('get.taxs.list');
        Route::post('/getTaxDetails',[TaxController::class, 'getTaxDetails'])->name('get.tax.details');
        Route::post('/updateTaxDetails',[TaxController::class, 'updateTaxDetails'])->name('update.tax.details');
        Route::post('/deleteTax',[TaxController::class,'deleteTax'])->name('delete.tax');
        Route::post('/deleteSelectedTaxs',[TaxController::class,'deleteSelectedTaxs'])->name('delete.selected.taxs');
        Route::resource('/taxs', TaxController::class);

        Route::resource('roles', RoleController::class);
        Route::resource('users', UserController::class);

        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    });


require __DIR__.'/auth.php';
