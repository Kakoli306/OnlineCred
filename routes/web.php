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


        //assign practice user
        Route::post('/practice-assign-get-all-user', [Controllers\Admin\AdminAssignPracticeController::class, 'practice_assign_get_all_user'])->name('admin.get.all.user');
        Route::post('/practice-assign-show-all-prc', [Controllers\Admin\AdminAssignPracticeController::class, 'practice_assign_show_all_prc'])->name('admin.practice.assign.show.all.prc');
        Route::post('/practice-assign-show-all-prc-user', [Controllers\Admin\AdminAssignPracticeController::class, 'practice_assign_show_all_prc_user'])->name('admin.practice.assign.get.by.user');
        Route::post('/practice-assign-add-user', [Controllers\Admin\AdminAssignPracticeController::class, 'practice_assign_user'])->name('admin.add.facility.user');
        Route::post('/practice-assign-remove-prc-foruser', [Controllers\Admin\AdminAssignPracticeController::class, 'practice_assign_remove_prc_for_user'])->name('admin.remove.facility.for.user');


        //create user
        Route::get('/create-user', [Controllers\Admin\AdminUserController::class, 'create_user'])->name('admin.create.user');
        Route::post('/create-user-save', [Controllers\Admin\AdminUserController::class, 'create_user_save'])->name('admin.create.user.save');
        Route::get('/all-admin-users', [Controllers\Admin\AdminUserController::class, 'all_admin_users'])->name('admin.all.admin.users');
        Route::get('/all-account-manager-users', [Controllers\Admin\AdminUserController::class, 'all_account_manager_users'])->name('admin.all.accountmanager.users');
        Route::get('/all-basestaff-users', [Controllers\Admin\AdminUserController::class, 'all_basestaff_users'])->name('admin.all.basestaff.users');
        Route::get('/user-edit/{id}/{type}', [Controllers\Admin\AdminUserController::class, 'user_edit'])->name('admin.user.edit');
        Route::post('/user-update', [Controllers\Admin\AdminUserController::class, 'user_update'])->name('admin.create.user.update');
        Route::post('/change-user-type', [Controllers\Admin\AdminUserController::class, 'change_user_type'])->name('admin.user.type.change');


        //provider
        Route::post('/provider-save', [Controllers\Admin\AdminProviderController::class, 'provider_save'])->name('admin.provider.save');
        Route::get('/provider-list', [Controllers\Admin\AdminProviderController::class, 'provider_list'])->name('admin.providers');
        Route::get('/provider-list-facility/{id}', [Controllers\Admin\AdminProviderController::class, 'provider_list_by_faiclity'])->name('admin.providers.list');
        Route::get('/provider-delete/{id}', [Controllers\Admin\AdminProviderController::class, 'provider_delete'])->name('admin.provider.delete');

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

        //insurance document
        Route::get('/provider-insurance-document/{id}', [Controllers\Admin\AdminProviderController::class, 'provider_insurance_document'])->name('admin.provider.insurance.document');
        Route::post('/provider-insurance-document-save', [Controllers\Admin\AdminProviderController::class, 'provider_insurance_document_save'])->name('admin.provider.insurance.document.save');
        Route::post('/provider-insurance-document-update', [Controllers\Admin\AdminProviderController::class, 'provider_insurance_document_update'])->name('admin.provider.insurance.document.update');
        Route::get('/provider-insurance-document-delete/{id}', [Controllers\Admin\AdminProviderController::class, 'provider_insurance_document_delete'])->name('admin.provider.insurance.document.delete');


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
        Route::get('/report-export/{id}', [Controllers\Admin\AdminReportController::class, 'report_export'])->name('admin.report.export');
        Route::post('/report-show-all-record', [Controllers\Admin\AdminReportController::class, 'report_show_all_record'])->name('admin.report.show.all');
        Route::get('/report-show-all-record', [Controllers\Admin\AdminReportController::class, 'report_show_all_record_get']);
        //account activity
        Route::get('/account-activity', [Controllers\Admin\AdminActivityController::class, 'account_activity'])->name('admin.account.activity');

        //reminder
        Route::get('/reminder', [Controllers\Admin\AdminReminderController::class, 'reminder'])->name('admin.reminder');
        Route::post('/reminder-get-all-prc', [Controllers\Admin\AdminReminderController::class, 'reminder_get_all_prc'])->name('admin.reminder.get.all.prc');
        Route::post('/reminder-get-prov-by-prc', [Controllers\Admin\AdminReminderController::class, 'reminder_al_prov_by_prc'])->name('admin.reminder.prov.by.fac');
        Route::post('/reminder-get-con-by-prov', [Controllers\Admin\AdminReminderController::class, 'reminder_con_by_prov'])->name('admin.reminder.con.by.prov');
        Route::post('/reminder-get-all-status', [Controllers\Admin\AdminReminderController::class, 'reminder_get_all_status'])->name('admin.reminder.get.all.status');
        Route::post('/reminder-get-all-users', [Controllers\Admin\AdminReminderController::class, 'reminder_get_all_users'])->name('admin.reminder.get.all.users');


        //reminder by filter
        Route::post('/reminder-show-all-record', [Controllers\Admin\AdminReminderController::class, 'reminder_show_all_record'])->name('admin.reminder.show.all');
        Route::get('/reminder-show-all-record', [Controllers\Admin\AdminReminderController::class, 'reminder_show_all_record_get']);
        Route::get('/reminder-all-data-get', [Controllers\Admin\AdminReminderController::class, 'reminder_all_data_get'])->name('admin.get.reminder.all.data');
        Route::get('/reminder-all-data-get-filter', [Controllers\Admin\AdminReminderController::class, 'reminder_all_data_get_filter'])->name('admin.get.reminder.all.data.filter');

        //reminder export
        Route::post('/reminder-export', [Controllers\Admin\AdminReminderController::class, 'reminder_export'])->name('admin.reminder.export');


        //download files
        Route::get('/download-files', [Controllers\Admin\AdminDownloadController::class, 'download_files'])->name('admin.download.files');
        Route::get('/download-reminder-files/{id}', [Controllers\Admin\AdminDownloadController::class, 'download_reminder_files'])->name('admin.reminder.download.file');


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

        //setting document type
        Route::get('/setting-document-type', [Controllers\Admin\AdminSettingController::class, 'document_type'])->name('admin.setting.document.type');
        Route::post('/setting-document-type-save', [Controllers\Admin\AdminSettingController::class, 'document_type_save'])->name('admin.setting.document.type.save');
        Route::post('/setting-document-type-update', [Controllers\Admin\AdminSettingController::class, 'document_type_update'])->name('admin.setting.document.type.update');
        Route::get('/setting-document-type-delete/{id}', [Controllers\Admin\AdminSettingController::class, 'document_type_delete'])->name('admin.setting.document.type.delete');

        //setting contract status
        Route::get('/setting-contract-status', [Controllers\Admin\AdminSettingController::class, 'contract_status'])->name('admin.setting.contract.status');
        Route::post('/setting-contract-status-save', [Controllers\Admin\AdminSettingController::class, 'contract_status_save'])->name('admin.setting.contract.status.save');
        Route::post('/setting-contract-status-update', [Controllers\Admin\AdminSettingController::class, 'contract_status_update'])->name('admin.setting.contract.status.update');
        Route::get('/setting-contract-status-delete/{id}', [Controllers\Admin\AdminSettingController::class, 'contract_status_delete'])->name('admin.setting.contract.status.delete');


    });
});


Route::prefix('account-manager')->group(function () {
    Route::get('/logout', [Controllers\Auth\AccountManagerLoginController::class, 'logout'])->name('account.manager.logout');
});

Route::group(['middleware' => ['auth:accountmanager']], function () {
    Route::prefix('account-manager')->group(function () {
        Route::get('/', [Controllers\Accountmanager\AccountManagerController::class, 'index'])->name('account.manager.dashboard');

        //provider
        Route::get('/provider', [Controllers\Accountmanager\AccManProviderController::class, 'provider'])->name('account.manager.provider');
        Route::post('/provider-save', [Controllers\Accountmanager\AccManProviderController::class, 'provider_save'])->name('account.manager.provider.save');
        Route::post('/provider-list-by-fid', [Controllers\Accountmanager\AccManProviderController::class, 'provider_list_by_fid'])->name('account.manager.provider.list.all.get.fid');
        Route::get('/provider-list-by-fid', [Controllers\Accountmanager\AccManProviderController::class, 'provider_list_by_fid_get']);
        Route::get('/provider-list-facility/{id}', [Controllers\Accountmanager\AccManProviderController::class, 'provider_list_by_faiclity'])->name('account.manager.providers.list');

        //provider info
        Route::get('/provider-info/{id}', [Controllers\Accountmanager\AccManProviderController::class, 'provider_info'])->name('account.manager.provider.info');
        Route::post('/provider-info-update', [Controllers\Accountmanager\AccManProviderController::class, 'provider_info_update'])->name('account.manager.provider.info.update');
        Route::post('/provider-info-delete-exists-phone', [Controllers\Accountmanager\AccManProviderController::class, 'provider_info_exists_phone_delete'])->name('account.manager.delete.exist.provider.phone');
        Route::post('/provider-info-delete-exists-email', [Controllers\Accountmanager\AccManProviderController::class, 'provider_info_exists_email_delete'])->name('account.manager.delete.exist.provider.email');
        Route::post('/provider-info-delete-exists-address', [Controllers\Accountmanager\AccManProviderController::class, 'provider_info_exists_address_delete'])->name('account.manager.delete.exist.provider.address');

        //provider contract
        Route::get('/provider-contract/{id}', [Controllers\Accountmanager\AccManProviderController::class, 'provider_contract'])->name('account.manager.provider.contract');
        Route::post('/provider-contract-save', [Controllers\Accountmanager\AccManProviderController::class, 'provider_contract_save'])->name('account.manager.provider.contract.save');
        Route::post('/provider-contract-update', [Controllers\Accountmanager\AccManProviderController::class, 'provider_contract_update'])->name('account.manager.provider.contract.update');
        Route::get('/provider-contract-delete/{id}', [Controllers\Accountmanager\AccManProviderController::class, 'provider_contract_delete'])->name('account.manager.provider.contract.delete');
        Route::post('/provider-contract-add-note', [Controllers\Accountmanager\AccManProviderController::class, 'provider_contract_add_note'])->name('account.manager.provider.contract.add.note');
        Route::post('/provider-contract-add-note-get', [Controllers\Accountmanager\AccManProviderController::class, 'provider_contract_note_get'])->name('account.manager.get.contract.note');

        //provider document
        Route::get('/provider-document/{id}', [Controllers\Accountmanager\AccManProviderController::class, 'provider_document'])->name('account.manager.provider.document');
        Route::post('/provider-document-save', [Controllers\Accountmanager\AccManProviderController::class, 'provider_document_save'])->name('account.manager.provider.document.save');
        Route::post('/provider-document-update', [Controllers\Accountmanager\AccManProviderController::class, 'provider_document_update'])->name('account.manager.provider.document.update');
        Route::get('/provider-document-delete/{id}', [Controllers\Accountmanager\AccManProviderController::class, 'provider_document_delete'])->name('account.manager.provider.document.delete');
        Route::post('/provider-document-all-doc-type', [Controllers\Accountmanager\AccManProviderController::class, 'provider_document_type_get_all'])->name('account.manager.provider.get.all.doc.type');

        //provider insurnace document
        Route::get('/provider-insurance-document/{id}', [Controllers\Accountmanager\AccManProviderController::class, 'provider_insurance_document'])->name('account.manager.provider.insurance.document');
        Route::post('/provider-insurance-document-save', [Controllers\Accountmanager\AccManProviderController::class, 'provider_insurance_document_save'])->name('account.manager.insurance.document.save');
        Route::post('/provider-insurance-document-update', [Controllers\Accountmanager\AccManProviderController::class, 'provider_insurance_document_update'])->name('account.manager.insurance.document.update');
        Route::get('/provider-insurance-document-delete/{id}', [Controllers\Accountmanager\AccManProviderController::class, 'provider_insurance_document_delete'])->name('account.manager.insurance.document.delete');

        //provider portal
        Route::get('/provider-portal/{id}', [Controllers\Accountmanager\AccManProviderController::class, 'provider_portal'])->name('account.manager.provider.portal');
        Route::post('/provider-portal-save', [Controllers\Accountmanager\AccManProviderController::class, 'provider_portal_save'])->name('account.manager.provider.portal.save');
        Route::post('/provider-portal-send-access', [Controllers\Accountmanager\AccManProviderController::class, 'provider_portal_send_access'])->name('account.manager.provider.send.access');

        //provider online access
        Route::get('/provider-online-access/{id}', [Controllers\Accountmanager\AccManProviderController::class, 'provider_online_access'])->name('account.manager.provider.online.access');
        Route::post('/provider-online-access-save', [Controllers\Accountmanager\AccManProviderController::class, 'provider_online_access_save'])->name('account.manager.provider.online.access.save');
        Route::post('/provider-online-access-update', [Controllers\Accountmanager\AccManProviderController::class, 'provider_online_access_update'])->name('account.manager.provider.online.access.update');
        Route::get('/provider-online-access-delete/{id}', [Controllers\Accountmanager\AccManProviderController::class, 'provider_online_access_delete'])->name('account.manager.provider.online.access.delete');

        //provider activity
        Route::get('/provider-activity/{id}', [Controllers\Accountmanager\AccManProviderController::class, 'provider_activity'])->name('account.manager.provider.activity');


        //report
        Route::get('/report', [Controllers\Accountmanager\AccManReportController::class, 'report'])->name('account.manager.report');
        Route::post('/report-get-all-facility', [Controllers\Accountmanager\AccManReportController::class, 'report_get_all_facility'])->name('account.manager.report.get.all.facility');
        Route::post('/report-provider-by-facility', [Controllers\Accountmanager\AccManReportController::class, 'report_provider_by_facility'])->name('account.manager.report.provider.by.facility');
        Route::post('/report-contract-by-provider', [Controllers\Accountmanager\AccManReportController::class, 'report_contract_by_provider'])->name('account.manager.report.contract.by.provider');
        Route::post('/report-save', [Controllers\Accountmanager\AccManReportController::class, 'report_save'])->name('account.manager.report.save');

        //acount acctivity
        Route::get('/account-activity', [Controllers\Accountmanager\AccManAccActivityController::class, 'account_activity'])->name('account.manager.account.activity');

        //reminder
        Route::post('/get-all-account', [Controllers\Accountmanager\AccManReminderController::class, 'get_all_account'])->name('account.manager.get.all.account');

        Route::get('/reminder', [Controllers\Accountmanager\AccManReminderController::class, 'reminders'])->name('account.manager.reminder');
        Route::post('/reminder-get-all-prc', [Controllers\Accountmanager\AccManReminderController::class, 'reminder_get_all_prc'])->name('account.manager.reminder.get.all.prc');
        Route::post('/reminder-get-prov-by-prc', [Controllers\Accountmanager\AccManReminderController::class, 'reminder_al_prov_by_prc'])->name('account.manager.reminder.prov.by.fac');
        Route::post('/reminder-get-con-by-prov', [Controllers\Accountmanager\AccManReminderController::class, 'reminder_con_by_prov'])->name('account.manager.reminder.con.by.prov');
        Route::post('/reminder-get-all-status', [Controllers\Accountmanager\AccManReminderController::class, 'reminder_get_all_status'])->name('account.manager.reminder.get.all.status');

        //reminder expoty
        Route::post('/reminder-export', [Controllers\Accountmanager\AccManReminderController::class, 'reminder_export'])->name('account.manager.reminder.export');


        //reminder by filter
        Route::post('/reminder-show-all-record', [Controllers\Accountmanager\AccManReminderController::class, 'reminder_show_all_record'])->name('account.manager.reminder.show.all');
        Route::get('/reminder-show-all-record', [Controllers\Accountmanager\AccManReminderController::class, 'reminder_show_all_record_get']);

        //download files
        Route::get('/download-files', [Controllers\Accountmanager\AccManDownloadController::class, 'download_files'])->name('account.manager.download.files');
        Route::get('/download-reminder-files/{id}', [Controllers\Accountmanager\AccManDownloadController::class, 'download_reminder_files'])->name('account.manager.reminder.download.file');

        //practice
        Route::post('/practice-save', [Controllers\Accountmanager\AccManPracticeController::class, 'practice_save'])->name('account.manager.practice.save');
        Route::get('/practice-list', [Controllers\Accountmanager\AccManPracticeController::class, 'practice_list'])->name('account.manager.practice.lists');
        Route::post('/practice-list-update', [Controllers\Accountmanager\AccManPracticeController::class, 'practice_list_update'])->name('account.manager.practice.update');


    });
});


Route::prefix('base-staff')->group(function () {
    Route::get('/logout', [Controllers\Auth\AccountManagerLoginController::class, 'logout'])->name('basestaff.logout');
});

Route::group(['middleware' => ['auth:basestaff']], function () {
    Route::prefix('base-staff')->group(function () {
        Route::get('/', [Controllers\BaseStaff\BaseStaffController::class, 'index'])->name('basestaff.dashboard');

        //provider
        Route::get('/provider', [Controllers\BaseStaff\BaseStaffProviderController::class, 'provider'])->name('basestaff.provider');
        Route::post('/provider-save', [Controllers\BaseStaff\BaseStaffProviderController::class, 'provider_save'])->name('basestaff.provider.save');
        Route::post('/provider-list-by-fid', [Controllers\BaseStaff\BaseStaffProviderController::class, 'provider_list_by_fid'])->name('basestaff.provider.list.all.get.fid');
        Route::get('/provider-list-by-fid', [Controllers\BaseStaff\BaseStaffProviderController::class, 'provider_list_by_fid_get']);
        Route::get('/provider-list-facility/{id}', [Controllers\BaseStaff\BaseStaffProviderController::class, 'provider_list_by_faiclity'])->name('basestaff.providers.list');

        //provider info
        Route::get('/provider-info/{id}', [Controllers\BaseStaff\BaseStaffProviderController::class, 'provider_info'])->name('basestaff.provider.info');
        Route::post('/provider-info-update', [Controllers\BaseStaff\BaseStaffProviderController::class, 'provider_info_update'])->name('basestaff.provider.info.update');
        Route::post('/provider-info-delete-exists-phone', [Controllers\BaseStaff\BaseStaffProviderController::class, 'provider_info_phone'])->name('basestaff.delete.exist.provider.phone');
        Route::post('/provider-info-delete-exists-email', [Controllers\BaseStaff\BaseStaffProviderController::class, 'provider_info_email'])->name('basestaff.delete.exist.provider.email');
        Route::post('/provider-info-delete-exists-address', [Controllers\BaseStaff\BaseStaffProviderController::class, 'provider_info_address'])->name('basestaff.delete.exist.provider.address');

        //provider contract
        Route::get('/provider-contract/{id}', [Controllers\BaseStaff\BaseStaffProviderController::class, 'provider_contract'])->name('basestaff.provider.contract');
        Route::post('/provider-contract-save', [Controllers\BaseStaff\BaseStaffProviderController::class, 'provider_contract_save'])->name('basestaff.provider.contract.save');
        Route::post('/provider-contract-update', [Controllers\BaseStaff\BaseStaffProviderController::class, 'provider_contract_update'])->name('basestaff.provider.contract.update');
        Route::get('/provider-contract-delete/{id}', [Controllers\BaseStaff\BaseStaffProviderController::class, 'provider_contract_delete'])->name('basestaff.provider.contract.delete');
        Route::post('/provider-contract-note-save', [Controllers\BaseStaff\BaseStaffProviderController::class, 'provider_contract_note_save'])->name('basestaff.provider.contract.add.note');
        Route::post('/provider-contract-note-get', [Controllers\BaseStaff\BaseStaffProviderController::class, 'provider_contract_note_get'])->name('basestaff.get.contract.note');

        //provider document
        Route::get('/provider-document/{id}', [Controllers\BaseStaff\BaseStaffProviderController::class, 'provider_document'])->name('basestaff.provider.document');
        Route::post('/provider-document-save', [Controllers\BaseStaff\BaseStaffProviderController::class, 'provider_document_save'])->name('basestaff.provider.document.save');
        Route::post('/provider-document-update', [Controllers\BaseStaff\BaseStaffProviderController::class, 'provider_document_update'])->name('basestaff.provider.document.update');
        Route::get('/provider-document-delete/{id}', [Controllers\BaseStaff\BaseStaffProviderController::class, 'provider_document_delete'])->name('basestaff.provider.document.delete');
        Route::post('/provider-document-all-doc-type', [Controllers\BaseStaff\BaseStaffProviderController::class, 'provider_document_all_doc_type'])->name('basestaff.provider.get.all.doc.type');

        //provider insurance docoument
        Route::get('/provider-insurance-document/{id}', [Controllers\BaseStaff\BaseStaffProviderController::class, 'provider_insurance_document'])->name('basestaff.insurance.document');
        Route::post('/provider-insurance-document-save', [Controllers\BaseStaff\BaseStaffProviderController::class, 'provider_insurance_document_save'])->name('basestaff.provider.insurance.document.save');
        Route::post('/provider-insurance-document-update', [Controllers\BaseStaff\BaseStaffProviderController::class, 'provider_insurance_document_update'])->name('basestaff.insurance.document.update');
        Route::get('/provider-insurance-document-delete/{id}', [Controllers\BaseStaff\BaseStaffProviderController::class, 'provider_insurance_document_delete'])->name('basestaff.provider.insurance.document.delete');

        //provider portal
        Route::get('/provider-portal/{id}', [Controllers\BaseStaff\BaseStaffProviderController::class, 'provider_portal'])->name('basestaff.provider.portal');
        Route::post('/provider-portal-save', [Controllers\BaseStaff\BaseStaffProviderController::class, 'provider_portal_save'])->name('basestaff.provider.portal.save');
        Route::post('/provider-portal-send-access', [Controllers\BaseStaff\BaseStaffProviderController::class, 'provider_portal_send_access'])->name('basestaff.provider.send.access');

        //provider online access
        Route::get('/provider-online-access/{id}', [Controllers\BaseStaff\BaseStaffProviderController::class, 'provider_online_access'])->name('basestaff.provider.online.access');
        Route::post('/provider-online-access-save', [Controllers\BaseStaff\BaseStaffProviderController::class, 'provider_online_access_save'])->name('basestaff.provider.online.access.save');
        Route::post('/provider-online-access-update', [Controllers\BaseStaff\BaseStaffProviderController::class, 'provider_online_access_update'])->name('basestaff.provider.online.access.update');
        Route::get('/provider-online-access-delete/{id}', [Controllers\BaseStaff\BaseStaffProviderController::class, 'provider_online_access_delete'])->name('basestaff.online.access.delete');

        //provider activity
        Route::get('/provider-activity/{id}', [Controllers\BaseStaff\BaseStaffProviderController::class, 'provider_activity'])->name('basestaff.provider.activity');


        //report
        Route::get('/report', [Controllers\BaseStaff\BaseStaffReportController::class, 'report'])->name('basestaff.report');
        Route::post('/report-get-all-facility', [Controllers\BaseStaff\BaseStaffReportController::class, 'report_get_all_facility'])->name('basestaff.report.get.all.facility');
        Route::post('/report-provider-by-facility', [Controllers\BaseStaff\BaseStaffReportController::class, 'report_provider_by_facility'])->name('basestaff.report.provider.by.facility');
        Route::post('/report-contract-by-provider', [Controllers\BaseStaff\BaseStaffReportController::class, 'report_contract_by_provider'])->name('basestaff.report.contract.by.provider');
        Route::post('/report-save', [Controllers\BaseStaff\BaseStaffReportController::class, 'report_save'])->name('basestaff.report.save');

        Route::get('/report-export/{id}', [Controllers\Admin\BaseStaffReportController::class, 'report_export'])->name('basestaff.report.export');

        //account activity
        Route::get('/account-activity', [Controllers\BaseStaff\BaseStaffAccActivityController::class, 'account_activity'])->name('basestaff.activity');

        //reminder
        Route::get('/reminders', [Controllers\BaseStaff\BaseStaffReminderController::class, 'reminders'])->name('basestaff.reminder');
        Route::post('/reminder-get-all-prc', [Controllers\BaseStaff\BaseStaffReminderController::class, 'reminder_get_all_prc'])->name('basestaff.reminder.get.all.prc');
        Route::post('/reminder-get-prov-by-prc', [Controllers\BaseStaff\BaseStaffReminderController::class, 'reminder_al_prov_by_prc'])->name('basestaff.reminder.prov.by.fac');
        Route::post('/reminder-get-con-by-prov', [Controllers\BaseStaff\BaseStaffReminderController::class, 'reminder_con_by_prov'])->name('basestaff.reminder.con.by.prov');
        Route::post('/reminder-get-all-status', [Controllers\BaseStaff\BaseStaffReminderController::class, 'reminder_get_all_status'])->name('basestaff.reminder.get.all.status');
        Route::post('/reminder-export', [Controllers\BaseStaff\BaseStaffReminderController::class, 'reminder_export'])->name('basestaff.reminder.export');


        //reminder by filter
        Route::post('/reminder-show-all-record', [Controllers\BaseStaff\BaseStaffReminderController::class, 'reminder_show_all_record'])->name('basestaff.reminder.show.all');
        Route::get('/reminder-show-all-record', [Controllers\BaseStaff\BaseStaffReminderController::class, 'reminder_show_all_record_get']);


        //download files
        Route::get('/download-files', [Controllers\BaseStaff\BaseStaffDownloadController::class, 'download_files'])->name('basestaff.download.files');
        Route::get('/download-reminder-files/{id}', [Controllers\BaseStaff\BaseStaffDownloadController::class, 'download_reminder_files'])->name('basestaff.reminder.download.file');


        //practice
        Route::get('/practice-list', [Controllers\BaseStaff\BaseStaffPracticeController::class, 'practice_list'])->name('basestaff.practice.lists');
        Route::post('/practice-update', [Controllers\BaseStaff\BaseStaffPracticeController::class, 'practice_update'])->name('basestaff.practice.update');

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
