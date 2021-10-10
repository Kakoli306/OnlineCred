<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;

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

Route::get('/', [Controllers\CustomLoginController::class, 'user_login'])->name('user.login');
Route::post('/user-login-submit', [Controllers\CustomLoginController::class, 'user_login_submit'])->name('user.login.submit');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



Route::prefix('admin')->group(function (){
    Route::get('/login', [Controllers\Auth\AdminLoginController::class,'showLoginform'])->name('admin.login');
    Route::post('/login', [Controllers\Auth\AdminLoginController::class,'login'])->name('admin.login.submit');
    Route::get('/logout', [Controllers\Auth\AdminLoginController::class,'logout'])->name('admin.logout');
});


Route::group(['middleware' => ['auth:admin']], function() {
    Route::prefix('admin')->group(function() {
        Route::get('/', [Controllers\Admin\AdminController::class,'index'])->name('admin.dashboard');

        //preactice
        Route::post('/practice-save', [Controllers\Admin\AdminPracticeController::class,'practice_save'])->name('admin.practice.save');

        //provider
        Route::post('/provider-save', [Controllers\Admin\AdminProviderController::class,'provider_save'])->name('admin.provider.save');
        Route::get('/provider-list', [Controllers\Admin\AdminProviderController::class,'provider_list'])->name('admin.providers');
        Route::get('/provider-info/{id}', [Controllers\Admin\AdminProviderController::class,'provider_info'])->name('admin.provider.info');
        Route::post('/provider-info-update', [Controllers\Admin\AdminProviderController::class,'provider_info_update'])->name('admin.provider.info.update');
        Route::post('/provider-info-exists-phone-delete', [Controllers\Admin\AdminProviderController::class,'provider_info_exists_phone_delete'])->name('admin.delete.exist.provider.phone');
        Route::post('/provider-info-exists-email-delete', [Controllers\Admin\AdminProviderController::class,'provider_info_exists_email_delete'])->name('admin.delete.exist.provider.email');
        Route::post('/provider-info-exists-address-delete', [Controllers\Admin\AdminProviderController::class,'provider_info_exists_address_delete'])->name('admin.delete.exist.provider.address');

        //provider contract
        Route::get('/provider-contract/{id}', [Controllers\Admin\AdminProviderController::class,'provider_contract'])->name('admin.provider.contract');
        Route::post('/provider-contract-save', [Controllers\Admin\AdminProviderController::class,'provider_contract_save'])->name('admin.provider.contract.save');
        Route::post('/provider-contract-update', [Controllers\Admin\AdminProviderController::class,'provider_contract_update'])->name('admin.provider.contract.update');
        Route::get('/provider-contract-delete/{id}', [Controllers\Admin\AdminProviderController::class,'provider_contract_delete'])->name('admin.provider.contract.delete');
        Route::post('/provider-contract-add-note', [Controllers\Admin\AdminProviderController::class,'provider_contract_add_note'])->name('admin.provider.contract.add.note');
        Route::post('/provider-contract-note-get', [Controllers\Admin\AdminProviderController::class,'provider_contract_note_get'])->name('admin.get.contract.note');

        //document
        Route::get('/provider-document/{id}', [Controllers\Admin\AdminProviderController::class,'provider_document'])->name('admin.provider.document');
        Route::post('/provider-document-save', [Controllers\Admin\AdminProviderController::class,'provider_document_save'])->name('admin.provider.document.save');
        Route::post('/provider-document-update', [Controllers\Admin\AdminProviderController::class,'provider_document_update'])->name('admin.provider.document.update');
        Route::get('/provider-document-delete/{id}', [Controllers\Admin\AdminProviderController::class,'provider_document_delete'])->name('admin.provider.document.delete');

        //provider portal
        Route::get('/provider-portal/{id}', [Controllers\Admin\AdminProviderController::class,'provider_portal'])->name('admin.provider.portal');
        Route::post('/provider-portal-save', [Controllers\Admin\AdminProviderController::class,'provider_portal_save'])->name('admin.provider.portal.save');

        //online access
        Route::get('/provider-online-access/{id}', [Controllers\Admin\AdminProviderController::class,'provider_online_access'])->name('admin.provider.online.access');
        Route::post('/provider-online-access-save', [Controllers\Admin\AdminProviderController::class,'provider_online_access_save'])->name('admin.provider.online.access.save');

        //tracking user
        Route::get('/provider-tracking-user/{id}', [Controllers\Admin\AdminProviderController::class,'provider_tracking_user'])->name('admin.provider.tracking.user');

        //provider activity
        Route::get('/provider-activity/{id}', [Controllers\Admin\AdminProviderController::class,'provider_activity'])->name('admin.provider.activity');
    });
});
