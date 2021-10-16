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


Route::get('/cache_clear',function(){
    Artisan::call('cache:clear');
});

Route::get('/view_clear',function(){
    Artisan::call('view:clear');
});
Route::get('/config_clear',function(){
    Artisan::call('config:cache');
});
Route::get('/route_clear',function(){
    Artisan::call('route:clear');
});




Route::get('/', [Controllers\CustomLoginController::class, 'user_login'])->name('user.login');
Route::post('/user-login-submit', [Controllers\CustomLoginController::class, 'user_login_submit'])->name('user.login.submit');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//access email
Route::get('/account-setup/{token}', [App\Http\Controllers\VisitorController::class, 'account_setup'])->name('access.email');
Route::post('/account-password-setup', [App\Http\Controllers\VisitorController::class, 'account_password_setup'])->name('provider.account.pass.setup');



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
        Route::get('/practice-lists', [Controllers\Admin\AdminPracticeController::class,'practice_lists'])->name('admin.practice.lists');
        Route::post('/practice-update', [Controllers\Admin\AdminPracticeController::class,'practice_update'])->name('admin.practice.update');
        Route::get('/practice-delete/{id}', [Controllers\Admin\AdminPracticeController::class,'practice_delete'])->name('admin.practice.delete');
        Route::post('/practice-get-all', [Controllers\Admin\AdminPracticeController::class,'practice_get_all'])->name('admin.get.all.practice');
        Route::post('/practice-add-provider', [Controllers\Admin\AdminPracticeController::class,'practice_add_provider'])->name('admin.add.facility.provider');
        Route::post('/practice-remove-provider', [Controllers\Admin\AdminPracticeController::class,'practice_remove_provider'])->name('admin.remove.facility.provider');
        Route::post('/practice-assign-get', [Controllers\Admin\AdminPracticeController::class,'practice_assign_get'])->name('admin.get.assin.practice');

        //practice assign
        Route::get('/practice-assign', [Controllers\Admin\AdminPracticeController::class,'practice_assign'])->name('admin.practice.assign');

        //provider
        Route::post('/provider-save', [Controllers\Admin\AdminProviderController::class,'provider_save'])->name('admin.provider.save');
        Route::get('/provider-list', [Controllers\Admin\AdminProviderController::class,'provider_list'])->name('admin.providers');
        Route::get('/provider-info/{id}', [Controllers\Admin\AdminProviderController::class,'provider_info'])->name('admin.provider.info');
        Route::post('/provider-info-update', [Controllers\Admin\AdminProviderController::class,'provider_info_update'])->name('admin.provider.info.update');
        Route::post('/provider-info-exists-phone-delete', [Controllers\Admin\AdminProviderController::class,'provider_info_exists_phone_delete'])->name('admin.delete.exist.provider.phone');
        Route::post('/provider-info-exists-email-delete', [Controllers\Admin\AdminProviderController::class,'provider_info_exists_email_delete'])->name('admin.delete.exist.provider.email');
        Route::post('/provider-info-exists-address-delete', [Controllers\Admin\AdminProviderController::class,'provider_info_exists_address_delete'])->name('admin.delete.exist.provider.address');
        Route::post('/get-all-provider', [Controllers\Admin\AdminProviderController::class,'get_all_provider'])->name('admin.get.all.provider');

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
        Route::post('/provider-portal-send-access', [Controllers\Admin\AdminProviderController::class,'provider_portal_send_access'])->name('admin.provider.send.access');

        //online access
        Route::get('/provider-online-access/{id}', [Controllers\Admin\AdminProviderController::class,'provider_online_access'])->name('admin.provider.online.access');
        Route::post('/provider-online-access-save', [Controllers\Admin\AdminProviderController::class,'provider_online_access_save'])->name('admin.provider.online.access.save');

        //tracking user
        Route::get('/provider-tracking-user/{id}', [Controllers\Admin\AdminProviderController::class,'provider_tracking_user'])->name('admin.provider.tracking.user');

        //provider activity
        Route::get('/provider-activity/{id}', [Controllers\Admin\AdminProviderController::class,'provider_activity'])->name('admin.provider.activity');

        //report
        Route::get('/report', [Controllers\Admin\AdminReportController::class,'report'])->name('admin.report');

        //account activity
        Route::get('/account-activity', [Controllers\Admin\AdminActivityController::class,'account_activity'])->name('admin.account.activity');
        Route::get('/reminder', [Controllers\Admin\AdminReminderController::class,'reminder'])->name('admin.reminder');
    });
});


Route::prefix('provider')->group(function (){
    Route::get('/login', [Controllers\Auth\ProviderLoginController::class,'provider_login_form'])->name('provider.login');
    Route::post('/login', [Controllers\Auth\ProviderLoginController::class,'provider_login'])->name('provider.login.submit');
    Route::get('/logout', [Controllers\Auth\ProviderLoginController::class,'provider_logout'])->name('provider.logout');
});



Route::group(['middleware' => ['auth:provider']], function() {
    Route::prefix('provider')->group(function() {
        Route::get('/', [Controllers\Provider\ProiderController::class,'index'])->name('provider.dashboard');
    });
});


