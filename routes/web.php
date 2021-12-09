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


Route::get('/cache_clear', function () {
    Artisan::call('cache:clear');
});

Route::get('/view_clear', function () {
    Artisan::call('view:clear');
});
Route::get('/config_clear', function () {
    Artisan::call('config:cache');
});
Route::get('/route_clear', function () {
    Artisan::call('route:clear');
});


Route::get('/', [Controllers\CustomLoginController::class, 'index'])->name('user.login');
Route::post('/user-login-submit', [Controllers\CustomLoginController::class, 'user_login_submit'])->name('user.login.submit');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//access email
Route::get('/account-setup/{token}', [App\Http\Controllers\VisitorController::class, 'account_setup'])->name('access.email');
Route::post('/account-password-setup', [App\Http\Controllers\VisitorController::class, 'account_password_setup'])->name('provider.account.pass.setup');


Route::get('/test-update-data', [Controllers\FrontendController::class, 'test_update_data'])->name('test.update.data');


Route::prefix('admin')->group(function () {
    Route::get('/login', [Controllers\Auth\AdminLoginController::class, 'showLoginform'])->name('admin.login');
    Route::post('/login', [Controllers\Auth\AdminLoginController::class, 'login'])->name('admin.login.submit');
    Route::get('/logout', [Controllers\Auth\AdminLoginController::class, 'logout'])->name('admin.logout');
});


Route::group(['middleware' => ['auth:admin']], function () {
    Route::prefix('admin')->group(function () {
        Route::get('/', [Controllers\Admin\AdminController::class, 'index'])->name('admin.dashboard');

        //preactice
        Route::post('/practice-save', [Controllers\Admin\AdminPracticeController::class, 'practice_save'])->name('admin.practice.save');
        Route::get('/practice-lists', [Controllers\Admin\AdminPracticeController::class, 'practice_lists'])->name('admin.practice.lists');
        Route::post('/practice-update', [Controllers\Admin\AdminPracticeController::class, 'practice_update'])->name('admin.practice.update');
        Route::get('/practice-delete/{id}', [Controllers\Admin\AdminPracticeController::class, 'practice_delete'])->name('admin.practice.delete');
        Route::post('/practice-get-all', [Controllers\Admin\AdminPracticeController::class, 'practice_get_all'])->name('admin.get.all.practice');
        Route::post('/practice-add-provider', [Controllers\Admin\AdminPracticeController::class, 'practice_add_provider'])->name('admin.add.facility.provider');
        Route::post('/practice-remove-provider', [Controllers\Admin\AdminPracticeController::class, 'practice_remove_provider'])->name('admin.remove.facility.provider');
        Route::post('/practice-assign-get', [Controllers\Admin\AdminPracticeController::class, 'practice_assign_get'])->name('admin.get.assin.practice');

        //practice assign
        Route::get('/practice-assign', [Controllers\Admin\AdminPracticeController::class, 'practice_assign'])->name('admin.practice.assign');


        //provider
        Route::post('/provider-save', [Controllers\Admin\AdminProviderController::class, 'provider_save'])->name('admin.provider.save');
        Route::get('/provider-list', [Controllers\Admin\AdminProviderController::class, 'provider_list'])->name('admin.providers');
        Route::get('/provider-list-facility/{id}', [Controllers\Admin\AdminProviderController::class, 'provider_list_by_faiclity'])->name('admin.providers.list');

        //get all provider
        Route::post('/provider-list-all-get', [Controllers\Admin\AdminProviderController::class, 'provider_list_get'])->name('admin.provider.list.all.get');
        Route::get('/provider-list-all-get', [Controllers\Admin\AdminProviderController::class, 'provider_list_get_next']);
        Route::post('/provider-list-all-get-fid', [Controllers\Admin\AdminProviderController::class, 'provider_list_get_fid'])->name('admin.provider.list.all.get.fid');
        Route::get('/provider-list-all-get-fid', [Controllers\Admin\AdminProviderController::class, 'provider_list_get_fid_next']);

        //provider info
        Route::get('/provider-info/{id}', [Controllers\Admin\AdminProviderController::class, 'provider_info'])->name('admin.provider.info');
        Route::post('/provider-info-update', [Controllers\Admin\AdminProviderController::class, 'provider_info_update'])->name('admin.provider.info.update');
        Route::post('/provider-info-exists-phone-delete', [Controllers\Admin\AdminProviderController::class, 'provider_info_exists_phone_delete'])->name('admin.delete.exist.provider.phone');
        Route::post('/provider-info-exists-email-delete', [Controllers\Admin\AdminProviderController::class, 'provider_info_exists_email_delete'])->name('admin.delete.exist.provider.email');
        Route::post('/provider-info-exists-address-delete', [Controllers\Admin\AdminProviderController::class, 'provider_info_exists_address_delete'])->name('admin.delete.exist.provider.address');
        Route::post('/get-all-provider', [Controllers\Admin\AdminProviderController::class, 'get_all_provider'])->name('admin.get.all.provider');

        //provider contract
        Route::get('/provider-contract/{id}', [Controllers\Admin\AdminProviderController::class, 'provider_contract'])->name('admin.provider.contract');
        Route::post('/provider-contract-save', [Controllers\Admin\AdminProviderController::class, 'provider_contract_save'])->name('admin.provider.contract.save');
        Route::post('/provider-contract-update', [Controllers\Admin\AdminProviderController::class, 'provider_contract_update'])->name('admin.provider.contract.update');
        Route::get('/provider-contract-delete/{id}', [Controllers\Admin\AdminProviderController::class, 'provider_contract_delete'])->name('admin.provider.contract.delete');
        Route::post('/provider-contract-add-note', [Controllers\Admin\AdminProviderController::class, 'provider_contract_add_note'])->name('admin.provider.contract.add.note');
        Route::post('/provider-contract-note-get', [Controllers\Admin\AdminProviderController::class, 'provider_contract_note_get'])->name('admin.get.contract.note');

        //document
        Route::get('/provider-document/{id}', [Controllers\Admin\AdminProviderController::class, 'provider_document'])->name('admin.provider.document');
        Route::post('/provider-document-save', [Controllers\Admin\AdminProviderController::class, 'provider_document_save'])->name('admin.provider.document.save');
        Route::post('/provider-document-update', [Controllers\Admin\AdminProviderController::class, 'provider_document_update'])->name('admin.provider.document.update');
        Route::get('/provider-document-delete/{id}', [Controllers\Admin\AdminProviderController::class, 'provider_document_delete'])->name('admin.provider.document.delete');
        Route::post('/provider-document-type-get-all', [Controllers\Admin\AdminProviderController::class, 'provider_document_type_get_all'])->name('admin.provider.get.all.doc.type');
        Route::post('/provider-document-type-save', [Controllers\Admin\AdminProviderController::class, 'provider_document_type_save'])->name('admin.provider.document.type.save');

        //provider portal
        Route::get('/provider-portal/{id}', [Controllers\Admin\AdminProviderController::class, 'provider_portal'])->name('admin.provider.portal');
        Route::post('/provider-portal-save', [Controllers\Admin\AdminProviderController::class, 'provider_portal_save'])->name('admin.provider.portal.save');
        Route::post('/provider-portal-send-access', [Controllers\Admin\AdminProviderController::class, 'provider_portal_send_access'])->name('admin.provider.send.access');

        //online access
        Route::get('/provider-online-access/{id}', [Controllers\Admin\AdminProviderController::class, 'provider_online_access'])->name('admin.provider.online.access');
        Route::post('/provider-online-access-save', [Controllers\Admin\AdminProviderController::class, 'provider_online_access_save'])->name('admin.provider.online.access.save');
        Route::post('/provider-online-access-update', [Controllers\Admin\AdminProviderController::class, 'provider_online_access_update'])->name('admin.provider.online.access.update');
        Route::get('/provider-online-access-delete/{id}', [Controllers\Admin\AdminProviderController::class, 'provider_online_access_delete'])->name('admin.provider.online.access.delete');

        //tracking user
        Route::get('/provider-tracking-user/{id}', [Controllers\Admin\AdminProviderController::class, 'provider_tracking_user'])->name('admin.provider.tracking.user');

        //provider activity
        Route::get('/provider-activity/{id}', [Controllers\Admin\AdminProviderController::class, 'provider_activity'])->name('admin.provider.activity');

        //report
        Route::get('/report', [Controllers\Admin\AdminReportController::class, 'report'])->name('admin.report');
        Route::post('/report-get-all-facility', [Controllers\Admin\AdminReportController::class, 'report_get_all_facility'])->name('admin.report.get.all.facility');
        Route::post('/report-get-provider-by-facility', [Controllers\Admin\AdminReportController::class, 'report_get_provider_by_facility'])->name('admin.report.provider.by.facility');
        Route::post('/report-get-contact-by-provider', [Controllers\Admin\AdminReportController::class, 'report_get_contact_by_provider'])->name('admin.report.contract.by.provider');
        Route::post('/report-save', [Controllers\Admin\AdminReportController::class, 'report_save'])->name('admin.report.save');

        //account activity
        Route::get('/account-activity', [Controllers\Admin\AdminActivityController::class, 'account_activity'])->name('admin.account.activity');
        Route::get('/reminder', [Controllers\Admin\AdminReminderController::class, 'reminder'])->name('admin.reminder');

        //setting contact name
        Route::get('/setting-contact-name', [Controllers\Admin\AdminSettingController::class, 'contact_name'])->name('admin.setting.contact.name');
        Route::post('/setting-contact-name-save', [Controllers\Admin\AdminSettingController::class, 'contact_name_save'])->name('admin.setting.contact.name.save');
        Route::post('/setting-contact-name-update', [Controllers\Admin\AdminSettingController::class, 'contact_name_update'])->name('admin.setting.contact.name.update');
        Route::get('/setting-contact-name-delete/{id}', [Controllers\Admin\AdminSettingController::class, 'contact_name_delete'])->name('admin.setting.contact.name.delete');

        //setting contact type
        Route::get('/setting-contact-type', [Controllers\Admin\AdminSettingController::class, 'contact_type'])->name('admin.setting.contact.type');
        Route::post('/setting-contact-type-save', [Controllers\Admin\AdminSettingController::class, 'contact_type_save'])->name('admin.setting.contact.type.save');
        Route::post('/setting-contact-type-update', [Controllers\Admin\AdminSettingController::class, 'contact_type_update'])->name('admin.setting.contact.type.update');
        Route::get('/setting-contact-type-delete/{id}', [Controllers\Admin\AdminSettingController::class, 'contact_type_delete'])->name('admin.setting.contact.type.delete');

        //setting Speciality
        Route::get('/setting-speciality', [Controllers\Admin\AdminSettingController::class, 'speciality'])->name('admin.setting.speciality');
        Route::post('/speciality-save', [Controllers\Admin\AdminSettingController::class, 'save_speciality'])->name('admin.speciality.save');
        Route::post('/speciality-update', [Controllers\Admin\AdminSettingController::class, 'save_speciality_update'])->name('admin.speciality.update');
        Route::get('/speciality-delete/{id}', [Controllers\Admin\AdminSettingController::class, 'save_speciality_delete'])->name('admin.speciality.delete');

        //setting insurance
        Route::get('/speciality-insurance', [Controllers\Admin\AdminSettingController::class, 'insurance'])->name('admin.setting.insurance');
        Route::post('/speciality-insurance-save', [Controllers\Admin\AdminSettingController::class, 'insurance_save'])->name('admin.setting.insurance.save');
        Route::post('/speciality-insurance-update', [Controllers\Admin\AdminSettingController::class, 'insurance_update'])->name('admin.setting.insurance.update');
        Route::get('/speciality-insurance-delete/{id}', [Controllers\Admin\AdminSettingController::class, 'insurance_delete'])->name('admin.setting.insurance.delete');


    });
});


Route::prefix('provider')->group(function () {
    Route::get('/login', [Controllers\Auth\ProviderLoginController::class, 'provider_login_form'])->name('provider.login');
    Route::post('/login', [Controllers\Auth\ProviderLoginController::class, 'provider_login'])->name('provider.login.submit');
    Route::get('/logout', [Controllers\Auth\ProviderLoginController::class, 'provider_logout'])->name('provider.logout');
});


Route::group(['middleware' => ['auth:provider']], function () {
    Route::prefix('provider')->group(function () {
        Route::get('/', [Controllers\Provider\ProiderController::class, 'index'])->name('provider.dashboard');

        //info
        Route::get('/info', [Controllers\Provider\ProiderInfoController::class, 'info'])->name('providers.info');
        Route::post('/info-update', [Controllers\Provider\ProiderInfoController::class, 'info_update'])->name('provider.info.update');
        Route::post('/delete-exits-phone', [Controllers\Provider\ProiderInfoController::class, 'delete_exists_phone'])->name('provider.delete.exist.phone');
        Route::post('/delete-exits-email', [Controllers\Provider\ProiderInfoController::class, 'delete_exists_email'])->name('provider.delete.exist.email');
        Route::post('/delete-exits-address', [Controllers\Provider\ProiderInfoController::class, 'delete_exists_address'])->name('provider.delete.exist.address');

        //provider contract
        Route::get('/contract', [Controllers\Provider\ProiderInfoController::class, 'contract'])->name('provider.contract');
        Route::post('/contract-save', [Controllers\Provider\ProiderInfoController::class, 'contract_save'])->name('provider.contract.save');
        Route::post('/contract-update', [Controllers\Provider\ProiderInfoController::class, 'contract_update'])->name('provider.contract.update');
        Route::get('/contract-delete/{id}', [Controllers\Provider\ProiderInfoController::class, 'contract_delete'])->name('provider.contract.delete');
        Route::post('/contract-add-note', [Controllers\Provider\ProiderInfoController::class, 'contract_add_note'])->name('provider.contract.add.note');
        Route::post('/contract-get-note', [Controllers\Provider\ProiderInfoController::class, 'contract_get_note'])->name('provider.get.contract.note');

        //document
        Route::get('/document', [Controllers\Provider\ProiderInfoController::class, 'document'])->name('provider.document');
        Route::post('/document-save', [Controllers\Provider\ProiderInfoController::class, 'document_save'])->name('provider.document.save');
        Route::post('/document-update', [Controllers\Provider\ProiderInfoController::class, 'document_update'])->name('provider.document.update');
        Route::get('/document-delete/{id}', [Controllers\Provider\ProiderInfoController::class, 'document_delete'])->name('provider.document.delete');

        //portal
        Route::get('/portal', [Controllers\Provider\ProiderInfoController::class, 'portal'])->name('provider.portal');
        Route::post('/portal-save', [Controllers\Provider\ProiderInfoController::class, 'portal_save'])->name('provider.portal.save');
        Route::post('/portal-send-access', [Controllers\Provider\ProiderInfoController::class, 'portal_send_access'])->name('provider.send.access');

        //online acccess
        Route::get('/online-access', [Controllers\Provider\ProiderInfoController::class, 'online_access'])->name('provider.online.access');
        Route::post('/online-access-save', [Controllers\Provider\ProiderInfoController::class, 'online_access_save'])->name('provider.online.access.save');

        //tracking user
        Route::get('/tracking-user', [Controllers\Provider\ProiderInfoController::class, 'tracking_user'])->name('provider.tracking.user');

        //activity
        Route::get('/activity', [Controllers\Provider\ProiderInfoController::class, 'activity'])->name('provider.activity');
    });
});
