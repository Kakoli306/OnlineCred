<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AccountManager;
use App\Models\Admin;
use App\Models\BaseStaff;
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

}
