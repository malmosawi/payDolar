<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\SuppliersController;
use App\Http\Controllers\SuppliersExpensesController;
use App\Http\Controllers\SuppliersCatchController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\InstallmentPayController;
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




Route::get('login', [LoginController::class, 'login'])->name('login');//->middleware('throttle:5,5');
Route::post('login', [LoginController::class, 'checklogin'])->name('checklogin');
Route::get('logout', [LoginController::class, 'logout'])->name('logout');


Route::group(['middleware' => 'auth'], function() {

    Route::post('login/{id}/profile', [LoginController::class, 'profile'])->name('profile');

    Route::get('setting', [SettingController::class, 'create'])->name('setting.create');
    Route::post('setting', [SettingController::class, 'store'])->name('setting.store');

    Route::get('customers', [CustomersController::class, 'default'])->name('customers.default');
    Route::get('customers/create', [CustomersController::class, 'create'])->name('customers.create');
    Route::post('customers/store', [CustomersController::class, 'store'])->name('customers.store');
    Route::get('customers/{id}/edit', [CustomersController::class, 'edit'])->name('customers.edit');
    Route::post('customers/{id}/update', [CustomersController::class, 'update'])->name('customers.update');
    Route::get('customers/destroy', [CustomersController::class, 'destroy'])->name('customers.destroy');

    Route::get('suppliers', [SuppliersController::class, 'default'])->name('suppliers.default');
    Route::get('suppliers/create', [SuppliersController::class, 'create'])->name('suppliers.create');
    Route::post('suppliers/store', [SuppliersController::class, 'store'])->name('suppliers.store');
    Route::get('suppliers/{id}/edit', [SuppliersController::class, 'edit'])->name('suppliers.edit');
    Route::post('suppliers/{id}/update', [SuppliersController::class, 'update'])->name('suppliers.update');

    Route::get('suppliersExpenses', [SuppliersExpensesController::class, 'default'])->name('suppliersExpenses.default');
    Route::get('suppliersExpenses/create', [SuppliersExpensesController::class, 'create'])->name('suppliersExpenses.create');
    Route::post('suppliersExpenses/store', [SuppliersExpensesController::class, 'store'])->name('suppliersExpenses.store');
    Route::get('suppliersExpenses/{id}/edit', [SuppliersExpensesController::class, 'edit'])->name('suppliersExpenses.edit');
    Route::post('suppliersExpenses/{id}/update', [SuppliersExpensesController::class, 'update'])->name('suppliersExpenses.update');
    Route::get('suppliersExpenses/get_money', [SuppliersExpensesController::class, 'get_money'])->name('suppliersExpenses.get_money');

    Route::get('suppliersCatch', [SuppliersCatchController::class, 'default'])->name('suppliersCatch.default');
    Route::get('suppliersCatch/create', [SuppliersCatchController::class, 'create'])->name('suppliersCatch.create');
    Route::post('suppliersCatch/store', [SuppliersCatchController::class, 'store'])->name('suppliersCatch.store');
    Route::get('suppliersCatch/{id}/edit', [SuppliersCatchController::class, 'edit'])->name('suppliersCatch.edit');
    Route::post('suppliersCatch/{id}/update', [SuppliersCatchController::class, 'update'])->name('suppliersCatch.update');

    Route::get('contract', [ContractController::class, 'default'])->name('contract.default');
    Route::get('contract/create', [ContractController::class, 'create'])->name('contract.create');
    Route::post('contract/store', [ContractController::class, 'store'])->name('contract.store');
    Route::get('contract/{id}/edit', [ContractController::class, 'edit'])->name('contract.edit');
    Route::post('contract/{id}/update', [ContractController::class, 'update'])->name('contract.update');

    Route::get('installmentPay', [InstallmentPayController::class, 'default'])->name('installmentPay.default');
    Route::get('installmentPay/create', [InstallmentPayController::class, 'create'])->name('installmentPay.create');
    Route::post('installmentPay/store', [InstallmentPayController::class, 'store'])->name('installmentPay.store');
    Route::get('installmentPay/{id}/edit', [InstallmentPayController::class, 'edit'])->name('installmentPay.edit');
    Route::post('installmentPay/{id}/update', [InstallmentPayController::class, 'update'])->name('installmentPay.update');
    
    // Route::get('users', 'UsersController@default')->name('users.default');
    // Route::get('users/create', 'UsersController@create')->name('users.create');
    // Route::post('users/store', 'UsersController@store')->name('users.store');
    // Route::get('users/{id}/edit', 'UsersController@edit')->name('users.edit');
    // Route::post('users/{id}/update', 'UsersController@update')->name('users.update');
    // Route::get('users/destroy', 'UsersController@destroy')->name('users.destroy');

});

// Route::get('/cacheClear', function () {
//     Artisan::call('route:clear');
//     dd("Cache is Cleared!!");
// });

// Route::get('/welcome', function () {
//     return view('welcome');
// });


// Route::get('/', function () {
//     return view('demo');
//  });

// Route::get('my-home', [HomeController::class, 'myHome']);
