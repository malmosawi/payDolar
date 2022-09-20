<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\SuppliersController;
use App\Http\Controllers\SuppliersExpensesController;
use App\Http\Controllers\SuppliersCatchController;
use App\Http\Controllers\ExpensesController;
use App\Http\Controllers\DisExpensesController;
use App\Http\Controllers\ConvertDolarToDinarController;
use App\Http\Controllers\ConvertDinarToDolarController;
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

Route::get('/', [LoginController::class, 'login'])->name('login');

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
    Route::get('suppliers/destroy', [SuppliersController::class, 'destroy'])->name('suppliers.destroy');
    Route::get('suppliers/{id}/show', [SuppliersController::class, 'show'])->name('suppliers.show');
    Route::get('suppliers/showAll', [SuppliersController::class, 'showAll'])->name('suppliers.showAll');
    

    Route::get('suppliersExpenses', [SuppliersExpensesController::class, 'default'])->name('suppliersExpenses.default');
    Route::get('suppliersExpenses/create', [SuppliersExpensesController::class, 'create'])->name('suppliersExpenses.create');
    Route::post('suppliersExpenses/store', [SuppliersExpensesController::class, 'store'])->name('suppliersExpenses.store');
    Route::get('suppliersExpenses/{id}/edit', [SuppliersExpensesController::class, 'edit'])->name('suppliersExpenses.edit');
    Route::post('suppliersExpenses/{id}/{old_money}/update', [SuppliersExpensesController::class, 'update'])->name('suppliersExpenses.update');
    Route::get('suppliersExpenses/destroy', [SuppliersExpensesController::class, 'destroy'])->name('suppliersExpenses.destroy');
    Route::get('suppliersExpenses/get_money', [SuppliersExpensesController::class, 'get_money'])->name('suppliersExpenses.get_money');
    Route::get('suppliersExpenses/{id}/print_catch', [SuppliersExpensesController::class, 'print_catch'])->name('suppliersExpenses.print_catch');

    Route::get('suppliersCatch', [SuppliersCatchController::class, 'default'])->name('suppliersCatch.default');
    Route::get('suppliersCatch/create', [SuppliersCatchController::class, 'create'])->name('suppliersCatch.create');
    Route::post('suppliersCatch/store', [SuppliersCatchController::class, 'store'])->name('suppliersCatch.store');
    Route::get('suppliersCatch/{id}/edit', [SuppliersCatchController::class, 'edit'])->name('suppliersCatch.edit');
    Route::post('suppliersCatch/{id}/{old_money}/update', [SuppliersCatchController::class, 'update'])->name('suppliersCatch.update');
    Route::get('suppliersCatch/destroy', [SuppliersCatchController::class, 'destroy'])->name('suppliersCatch.destroy');
    Route::get('suppliersCatch/get_money', [SuppliersCatchController::class, 'get_money'])->name('suppliersCatch.get_money');
    Route::get('suppliersCatch/{id}/print_catch', [SuppliersCatchController::class, 'print_catch'])->name('suppliersCatch.print_catch');

    Route::get('expenses', [ExpensesController::class, 'default'])->name('expenses.default');
    Route::get('expenses/create', [ExpensesController::class, 'create'])->name('expenses.create');
    Route::post('expenses/store', [ExpensesController::class, 'store'])->name('expenses.store');
    Route::get('expenses/{id}/edit', [ExpensesController::class, 'edit'])->name('expenses.edit');
    Route::post('expenses/{id}/update', [ExpensesController::class, 'update'])->name('expenses.update');
    Route::get('expenses/destroy', [ExpensesController::class, 'destroy'])->name('expenses.destroy');
    Route::post('expenses/{id}/show', [ExpensesController::class, 'show'])->name('expenses.show');
    Route::post('expenses/showAll', [ExpensesController::class, 'showAll'])->name('expenses.showAll');

    Route::get('disexpenses', [DisExpensesController::class, 'default'])->name('disexpenses.default');
    Route::get('disexpenses/create', [DisExpensesController::class, 'create'])->name('disexpenses.create');
    Route::post('disexpenses/store', [DisExpensesController::class, 'store'])->name('disexpenses.store');
    Route::get('disexpenses/{id}/edit', [DisExpensesController::class, 'edit'])->name('disexpenses.edit');
    Route::post('disexpenses/{id}/{old_money}/update', [DisExpensesController::class, 'update'])->name('disexpenses.update');
    Route::get('disexpenses/destroy', [DisExpensesController::class, 'destroy'])->name('disexpenses.destroy');

    Route::get('convertDolarToDinar', [ConvertDolarToDinarController::class, 'default'])->name('convertDolarToDinar.default');
    Route::get('convertDolarToDinar/create', [ConvertDolarToDinarController::class, 'create'])->name('convertDolarToDinar.create');
    Route::post('convertDolarToDinar/store', [ConvertDolarToDinarController::class, 'store'])->name('convertDolarToDinar.store');
    Route::get('convertDolarToDinar/{id}/edit', [ConvertDolarToDinarController::class, 'edit'])->name('convertDolarToDinar.edit');
    Route::post('convertDolarToDinar/{id}/{old_money_dolar}/{old_money_dinar}/update', [ConvertDolarToDinarController::class, 'update'])->name('convertDolarToDinar.update');
    Route::get('convertDolarToDinar/destroy', [ConvertDolarToDinarController::class, 'destroy'])->name('convertDolarToDinar.destroy');

    Route::get('convertDinarToDolar', [ConvertDinarToDolarController::class, 'default'])->name('convertDinarToDolar.default');
    Route::get('convertDinarToDolar/create', [ConvertDinarToDolarController::class, 'create'])->name('convertDinarToDolar.create');
    Route::post('convertDinarToDolar/store', [ConvertDinarToDolarController::class, 'store'])->name('convertDinarToDolar.store');
    Route::get('convertDinarToDolar/{id}/edit', [ConvertDinarToDolarController::class, 'edit'])->name('convertDinarToDolar.edit');
    Route::post('convertDinarToDolar/{id}/{old_money_dolar}/{old_money_dinar}/update', [ConvertDinarToDolarController::class, 'update'])->name('convertDinarToDolar.update');
    Route::get('convertDinarToDolar/destroy', [ConvertDinarToDolarController::class, 'destroy'])->name('convertDinarToDolar.destroy');
    
    Route::get('contract', [ContractController::class, 'default'])->name('contract.default');
    Route::get('contract/create', [ContractController::class, 'create'])->name('contract.create');
    Route::post('contract/store', [ContractController::class, 'store'])->name('contract.store');
    Route::get('contract/{id}/edit', [ContractController::class, 'edit'])->name('contract.edit');
    Route::post('contract/{id}/{old_money_dolar}/update', [ContractController::class, 'update'])->name('contract.update');
    Route::get('contract/destroy', [ContractController::class, 'destroy'])->name('contract.destroy');
    Route::get('contract/{id}/print_catch', [ContractController::class, 'print_catch'])->name('contract.print_catch');

    Route::get('installmentPay', [InstallmentPayController::class, 'default'])->name('installmentPay.default');
    Route::get('installmentPay/{id}/show', [InstallmentPayController::class, 'show'])->name('installmentPay.show');
    //Route::get('installmentPay/{id_contract}/{kist_dinar}/{month}/store', [InstallmentPayController::class, 'store'])->name('installmentPay.store');
    Route::post('installmentPay/{id_contract}/{modal_id}/{month}/store', [InstallmentPayController::class, 'store'])->name('installmentPay.store');
    Route::get('installmentPay/{id_contract}/{date_contract}/{month}/print_catch', [InstallmentPayController::class, 'print_catch'])->name('installmentPay.print_catch');
    //Route::get('installmentPay/get_table', [InstallmentPayController::class, 'get_table'])->name('installmentPay.get_table');
    
    // Route::get('users', 'UsersController@default')->name('users.default');
    // Route::get('users/create', 'UsersController@create')->name('users.create');
    // Route::post('users/store', 'UsersController@store')->name('users.store');
    // Route::get('users/{id}/edit', 'UsersController@edit')->name('users.edit');
    // Route::post('users/{id}/update', 'UsersController@update')->name('users.update');
    // Route::get('users/destroy', 'UsersController@destroy')->name('users.destroy');

});

