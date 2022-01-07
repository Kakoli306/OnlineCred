<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AccountManager;
use App\Models\Admin;
use App\Models\assign_practice_user;
use App\Models\BaseStaff;
use App\Models\provider_contract;
use App\Models\provider_contract_note;
use App\Models\reminder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    public function create_user()
    {
        return view('admin.user.createUser');
    }

    public function create_user_save(Request $request)
    {
        $type = $request->account_type;
        if ($type == 0) {
            return back()->with('alert', 'Please select account type');
        } elseif ($type == 1) {


            $check_user = Admin::where('name', $request->name)->first();
            if ($check_user) {
                return back()->with('alert', 'Username already exists. Please Choose another');
                exit();
            }

            $new_admin = new Admin();
            $new_admin->name = $request->name;
            $new_admin->actual_name = $request->actual_name;
            $new_admin->email = $request->email;
            $new_admin->phone_number = $request->phone_number;
            $new_admin->account_status = $request->account_status;
            $new_admin->password = Hash::make($request->password);
            $new_admin->account_type = $type;
            $new_admin->save();
            return back()->with('success', 'Admin User Successfully Created');
        } elseif ($type == 2) {
            $check_user = AccountManager::where('name', $request->name)->first();
            if ($check_user) {
                return back()->with('alert', 'Username already exists. Please Choose another');
                exit();
            }
            $new_admin = new AccountManager();
            $new_admin->name = $request->name;
            $new_admin->actual_name = $request->actual_name;
            $new_admin->email = $request->email;
            $new_admin->phone_number = $request->phone_number;
            $new_admin->account_status = $request->account_status;
            $new_admin->password = Hash::make($request->password);
            $new_admin->account_type = $type;
            $new_admin->save();
            return back()->with('success', 'Account Manager User Successfully Created');
        } elseif ($type == 3) {
            $check_user = BaseStaff::where('name', $request->name)->first();
            if ($check_user) {
                return back()->with('alert', 'Username already exists. Please Choose another');
                exit();
            }
            $new_admin = new BaseStaff();
            $new_admin->name = $request->name;
            $new_admin->actual_name = $request->actual_name;
            $new_admin->email = $request->email;
            $new_admin->phone_number = $request->phone_number;
            $new_admin->account_status = $request->account_status;
            $new_admin->password = Hash::make($request->password);
            $new_admin->account_type = $type;
            $new_admin->save();
            return back()->with('success', 'Base Staff User Successfully Created');
        }
    }


    public function all_admin_users()
    {
        $all_admins = Admin::orderBy('id', 'desc')->paginate(10);
        return view('admin.user.allAdminUsers', compact('all_admins'));
    }

    public function all_account_manager_users()
    {
        $all_acc_manager = AccountManager::orderBy('id', 'desc')->paginate(10);
        return view('admin.user.allAccountManager', compact('all_acc_manager'));
    }

    public function all_basestaff_users()
    {
        $all_base_staff = BaseStaff::orderBy('id', 'desc')->paginate(10);
        return view('admin.user.allBaseStaff', compact('all_base_staff'));
    }

    public function user_edit($id, $type)
    {
        $type_id = $type;
        if ($type == 1) {
            $user = Admin::where('id', $id)->first();
        } elseif ($type == 2) {
            $user = AccountManager::where('id', $id)->first();
        } elseif ($type == 3) {
            $user = BaseStaff::where('id', $id)->first();
        } else {
            return back()->with('alert', 'User Not Found');
        }
        return view('admin.user.editUser', compact('user', 'type_id'));
    }


    public function user_update(Request $request)
    {
        $type = $request->user_type;
        if ($type == 1) {
            $user = Admin::where('id', $request->user_id)->first();
            $user->name = $request->name;
            $user->actual_name = $request->actual_name;
            $user->email = $request->email;
            $user->phone_number = $request->phone_number;
            $user->account_status = $request->account_status;
            if ($request->password != null || $request->password != '') {
                $user->password = Hash::make($request->password);
            }
            $user->account_type = $type;
            $user->save();
            return back()->with('success', 'Admin User Successfully Updated');
        } elseif ($type == 2) {
            $user = AccountManager::where('id', $request->user_id)->first();
            $user->name = $request->name;
            $user->actual_name = $request->actual_name;
            $user->email = $request->email;
            $user->phone_number = $request->phone_number;
            $user->account_status = $request->account_status;
            if ($request->password != null || $request->password != '') {
                $user->password = Hash::make($request->password);
            }
            $user->account_type = $type;
            $user->save();
            return back()->with('success', 'Admin User Successfully Updated');
        } elseif ($type == 3) {
            $user = BaseStaff::where('id', $request->user_id)->first();
            $user->name = $request->name;
            $user->actual_name = $request->actual_name;
            $user->email = $request->email;
            $user->phone_number = $request->phone_number;
            $user->account_status = $request->account_status;
            if ($request->password != null || $request->password != '') {
                $user->password = Hash::make($request->password);
            }
            $user->account_type = $type;
            $user->save();
            return back()->with('success', 'Admin User Successfully Updated');
        } else {
            return back()->with('alert', 'User Not Found');
        }
    }


    public function change_user_type(Request $request)
    {
        $type = $request->acc_type_change;

        if ($request->acc_type == 1) {
            $user = Admin::where('id', $request->user_id)->first();

            if ($type == 1) {

                $new_user = new Admin();
                $new_user->name = $user->name;
                $new_user->actual_name = $user->actual_name;
                $new_user->email = $user->email;
                $new_user->phone_number = $user->phone_number;
                $new_user->password = $user->password;
                $new_user->account_type = 1;
                $new_user->account_status = $user->account_status;
                $new_user->save();


                $assign_prc_count = assign_practice_user::where('user_id', $user->id)
                    ->where('user_type', $user->account_type)->count();

                if ($assign_prc_count > 0) {
                    $assign_prc = assign_practice_user::where('user_id', $user->id)
                        ->where('user_type', $user->account_type)
                        ->update(['user_id' => $new_user->id, 'user_type' => $new_user->account_type]);
                }

                $prov_con_count = provider_contract_note::where('user_id', $user->id)->where('user_type', $user->account_type)->count();
                if ($prov_con_count > 0) {
                    $prov_con_count = provider_contract_note::where('user_id', $user->id)
                        ->where('user_type', $user->account_type)
                        ->update(['user_id' => $new_user->id, 'user_type' => $new_user->account_type]);
                }

                $reminder_count = reminder::where('user_id', $user->id)->where('user_type', $user->account_type)->count();
                if ($reminder_count > 0) {
                    reminder::where('user_id', $user->id)
                        ->where('user_type', $user->account_type)
                        ->update(['user_id' => $new_user->id, 'user_type' => $new_user->account_type]);
                }

                $user->delete();

                return back()->with('success', 'Successfully Account Changed to Admin');

            } elseif ($type == 2) {

                $new_user = new AccountManager();
                $new_user->name = $user->name;
                $new_user->actual_name = $user->actual_name;
                $new_user->email = $user->email;
                $new_user->phone_number = $user->phone_number;
                $new_user->password = $user->password;
                $new_user->account_type = 2;
                $new_user->account_status = $user->account_status;
                $new_user->save();


                $assign_prc_count = assign_practice_user::where('user_id', $user->id)
                    ->where('user_type', $user->account_type)->count();

                if ($assign_prc_count > 0) {
                    $assign_prc = assign_practice_user::where('user_id', $user->id)
                        ->where('user_type', $user->account_type)
                        ->update(['user_id' => $new_user->id, 'user_type' => $new_user->account_type]);
                }

                $prov_con_count = provider_contract_note::where('user_id', $user->id)->where('user_type', $user->account_type)->count();
                if ($prov_con_count > 0) {
                    $prov_con_count = provider_contract_note::where('user_id', $user->id)
                        ->where('user_type', $user->account_type)
                        ->update(['user_id' => $new_user->id, 'user_type' => $new_user->account_type]);
                }

                $reminder_count = reminder::where('user_id', $user->id)->where('user_type', $user->account_type)->count();
                if ($reminder_count > 0) {
                    reminder::where('user_id', $user->id)
                        ->where('user_type', $user->account_type)
                        ->update(['user_id' => $new_user->id, 'user_type' => $new_user->account_type]);
                }

                $user->delete();
                return back()->with('success', 'Successfully Account Changed to Account Manage');
            } elseif ($type == 3) {
                $new_user = new BaseStaff();
                $new_user->name = $user->name;
                $new_user->actual_name = $user->actual_name;
                $new_user->email = $user->email;
                $new_user->phone_number = $user->phone_number;
                $new_user->password = $user->password;
                $new_user->account_type = 3;
                $new_user->account_status = $user->account_status;
                $new_user->save();


                $assign_prc_count = assign_practice_user::where('user_id', $user->id)
                    ->where('user_type', $user->account_type)->count();

                if ($assign_prc_count > 0) {
                    $assign_prc = assign_practice_user::where('user_id', $user->id)
                        ->where('user_type', $user->account_type)
                        ->update(['user_id' => $new_user->id, 'user_type' => $new_user->account_type]);
                }

                $prov_con_count = provider_contract_note::where('user_id', $user->id)->where('user_type', $user->account_type)->count();
                if ($prov_con_count > 0) {
                    $prov_con_count = provider_contract_note::where('user_id', $user->id)
                        ->where('user_type', $user->account_type)
                        ->update(['user_id' => $new_user->id, 'user_type' => $new_user->account_type]);
                }

                $reminder_count = reminder::where('user_id', $user->id)->where('user_type', $user->account_type)->count();
                if ($reminder_count > 0) {
                    reminder::where('user_id', $user->id)
                        ->where('user_type', $user->account_type)
                        ->update(['user_id' => $new_user->id, 'user_type' => $new_user->account_type]);
                }

                $user->delete();
                return back()->with('success', 'Successfully Account Changed to Base Staff');
            } else {
                return back()->with('alert', 'Something Went Wrong');
            }
        } elseif ($request->acc_type == 2) {
            $user = AccountManager::where('id', $request->user_id)->first();

            if ($type == 1) {

                $new_user = new Admin();
                $new_user->name = $user->name;
                $new_user->actual_name = $user->actual_name;
                $new_user->email = $user->email;
                $new_user->phone_number = $user->phone_number;
                $new_user->password = $user->password;
                $new_user->account_type = 1;
                $new_user->account_status = $user->account_status;
                $new_user->save();


                $assign_prc_count = assign_practice_user::where('user_id', $user->id)
                    ->where('user_type', $user->account_type)->count();

                if ($assign_prc_count > 0) {
                    $assign_prc = assign_practice_user::where('user_id', $user->id)
                        ->where('user_type', $user->account_type)
                        ->update(['user_id' => $new_user->id, 'user_type' => $new_user->account_type]);
                }

                $prov_con_count = provider_contract_note::where('user_id', $user->id)->where('user_type', $user->account_type)->count();
                if ($prov_con_count > 0) {
                    $prov_con_count = provider_contract_note::where('user_id', $user->id)
                        ->where('user_type', $user->account_type)
                        ->update(['user_id' => $new_user->id, 'user_type' => $new_user->account_type]);
                }

                $reminder_count = reminder::where('user_id', $user->id)->where('user_type', $user->account_type)->count();
                if ($reminder_count > 0) {
                    reminder::where('user_id', $user->id)
                        ->where('user_type', $user->account_type)
                        ->update(['user_id' => $new_user->id, 'user_type' => $new_user->account_type]);
                }

                $user->delete();
                return back()->with('success', 'Successfully Account Changed to Admin');
            } elseif ($type == 2) {
                $new_user = new AccountManager();
                $new_user->name = $user->name;
                $new_user->actual_name = $user->actual_name;
                $new_user->email = $user->email;
                $new_user->phone_number = $user->phone_number;
                $new_user->password = $user->password;
                $new_user->account_type = 2;
                $new_user->account_status = $user->account_status;
                $new_user->save();


                $assign_prc_count = assign_practice_user::where('user_id', $user->id)
                    ->where('user_type', $user->account_type)->count();

                if ($assign_prc_count > 0) {
                    $assign_prc = assign_practice_user::where('user_id', $user->id)
                        ->where('user_type', $user->account_type)
                        ->update(['user_id' => $new_user->id, 'user_type' => $new_user->account_type]);
                }

                $prov_con_count = provider_contract_note::where('user_id', $user->id)->where('user_type', $user->account_type)->count();
                if ($prov_con_count > 0) {
                    $prov_con_count = provider_contract_note::where('user_id', $user->id)
                        ->where('user_type', $user->account_type)
                        ->update(['user_id' => $new_user->id, 'user_type' => $new_user->account_type]);
                }

                $reminder_count = reminder::where('user_id', $user->id)->where('user_type', $user->account_type)->count();
                if ($reminder_count > 0) {
                    reminder::where('user_id', $user->id)
                        ->where('user_type', $user->account_type)
                        ->update(['user_id' => $new_user->id, 'user_type' => $new_user->account_type]);
                }

                $user->delete();
                return back()->with('success', 'Successfully Account Changed to Account Manager');
            } elseif ($type == 3) {
                $new_user = new BaseStaff();
                $new_user->name = $user->name;
                $new_user->actual_name = $user->actual_name;
                $new_user->email = $user->email;
                $new_user->phone_number = $user->phone_number;
                $new_user->password = $user->password;
                $new_user->account_type = 3;
                $new_user->account_status = $user->account_status;
                $new_user->save();


                $assign_prc_count = assign_practice_user::where('user_id', $user->id)
                    ->where('user_type', $user->account_type)->count();

                if ($assign_prc_count > 0) {
                    $assign_prc = assign_practice_user::where('user_id', $user->id)
                        ->where('user_type', $user->account_type)
                        ->update(['user_id' => $new_user->id, 'user_type' => $new_user->account_type]);
                }

                $prov_con_count = provider_contract_note::where('user_id', $user->id)->where('user_type', $user->account_type)->count();
                if ($prov_con_count > 0) {
                    $prov_con_count = provider_contract_note::where('user_id', $user->id)
                        ->where('user_type', $user->account_type)
                        ->update(['user_id' => $new_user->id, 'user_type' => $new_user->account_type]);
                }

                $reminder_count = reminder::where('user_id', $user->id)->where('user_type', $user->account_type)->count();
                if ($reminder_count > 0) {
                    reminder::where('user_id', $user->id)
                        ->where('user_type', $user->account_type)
                        ->update(['user_id' => $new_user->id, 'user_type' => $new_user->account_type]);
                }

                $user->delete();
                return back()->with('success', 'Successfully Account Changed to Base Staff');
            } else {
                return back()->with('alert', 'Something Went Wrong');
            }

        } elseif ($request->acc_type == 3) {

            $user = BaseStaff::where('id', $request->user_id)->first();


            if ($type == 1) {

                $new_user = new Admin();
                $new_user->name = $user->name;
                $new_user->actual_name = $user->actual_name;
                $new_user->email = $user->email;
                $new_user->phone_number = $user->phone_number;
                $new_user->password = $user->password;
                $new_user->account_type = 1;
                $new_user->account_status = $user->account_status;
                $new_user->save();


                $assign_prc_count = assign_practice_user::where('user_id', $user->id)
                    ->where('user_type', $user->account_type)->count();

                if ($assign_prc_count > 0) {
                    $assign_prc = assign_practice_user::where('user_id', $user->id)
                        ->where('user_type', $user->account_type)
                        ->update(['user_id' => $new_user->id, 'user_type' => $new_user->account_type]);
                }

                $prov_con_count = provider_contract_note::where('user_id', $user->id)->where('user_type', $user->account_type)->count();
                if ($prov_con_count > 0) {
                    $prov_con_count = provider_contract_note::where('user_id', $user->id)
                        ->where('user_type', $user->account_type)
                        ->update(['user_id' => $new_user->id, 'user_type' => $new_user->account_type]);
                }

                $reminder_count = reminder::where('user_id', $user->id)->where('user_type', $user->account_type)->count();
                if ($reminder_count > 0) {
                    reminder::where('user_id', $user->id)
                        ->where('user_type', $user->account_type)
                        ->update(['user_id' => $new_user->id, 'user_type' => $new_user->account_type]);
                }

                $user->delete();
                return back()->with('success', 'Successfully Account Changed to Admin');
            } elseif ($type == 2) {
                $new_user = new AccountManager();
                $new_user->name = $user->name;
                $new_user->actual_name = $user->actual_name;
                $new_user->email = $user->email;
                $new_user->phone_number = $user->phone_number;
                $new_user->password = $user->password;
                $new_user->account_type = 2;
                $new_user->account_status = $user->account_status;
                $new_user->save();


                $assign_prc_count = assign_practice_user::where('user_id', $user->id)
                    ->where('user_type', $user->account_type)->count();

                if ($assign_prc_count > 0) {
                    $assign_prc = assign_practice_user::where('user_id', $user->id)
                        ->where('user_type', $user->account_type)
                        ->update(['user_id' => $new_user->id, 'user_type' => $new_user->account_type]);
                }

                $prov_con_count = provider_contract_note::where('user_id', $user->id)->where('user_type', $user->account_type)->count();
                if ($prov_con_count > 0) {
                    $prov_con_count = provider_contract_note::where('user_id', $user->id)
                        ->where('user_type', $user->account_type)
                        ->update(['user_id' => $new_user->id, 'user_type' => $new_user->account_type]);
                }

                $reminder_count = reminder::where('user_id', $user->id)->where('user_type', $user->account_type)->count();
                if ($reminder_count > 0) {
                    reminder::where('user_id', $user->id)
                        ->where('user_type', $user->account_type)
                        ->update(['user_id' => $new_user->id, 'user_type' => $new_user->account_type]);
                }

                $user->delete();
                return back()->with('success', 'Successfully Account Changed to Account Manager');
            } elseif ($type == 3) {
                $new_user = new BaseStaff();
                $new_user->name = $user->name;
                $new_user->actual_name = $user->actual_name;
                $new_user->email = $user->email;
                $new_user->phone_number = $user->phone_number;
                $new_user->password = $user->password;
                $new_user->account_type = 3;
                $new_user->account_status = $user->account_status;
                $new_user->save();


                $assign_prc_count = assign_practice_user::where('user_id', $user->id)
                    ->where('user_type', $user->account_type)->count();

                if ($assign_prc_count > 0) {
                    $assign_prc = assign_practice_user::where('user_id', $user->id)
                        ->where('user_type', $user->account_type)
                        ->update(['user_id' => $new_user->id, 'user_type' => $new_user->account_type]);
                }

                $prov_con_count = provider_contract_note::where('user_id', $user->id)->where('user_type', $user->account_type)->count();
                if ($prov_con_count > 0) {
                    $prov_con_count = provider_contract_note::where('user_id', $user->id)
                        ->where('user_type', $user->account_type)
                        ->update(['user_id' => $new_user->id, 'user_type' => $new_user->account_type]);
                }

                $reminder_count = reminder::where('user_id', $user->id)->where('user_type', $user->account_type)->count();
                if ($reminder_count > 0) {
                    reminder::where('user_id', $user->id)
                        ->where('user_type', $user->account_type)
                        ->update(['user_id' => $new_user->id, 'user_type' => $new_user->account_type]);
                }

                $user->delete();
                return back()->with('success', 'Successfully Account Changed to Base Staff');
            } else {
                return back()->with('alert', 'Something Went Wrong');
            }
        } else {
            return back()->with('alert', 'Something Went Wrong');
        }


    }

}
