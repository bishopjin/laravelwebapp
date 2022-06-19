<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class HomeController extends Controller
{
    /* select web app user access */
    protected function AppAccess(Request $request, $urlPath, $accessLevel) 
    {
        /* remove role and permission */
        $request->user()->syncRoles([]);
        $request->user()->syncPermissions([]);

        if ($urlPath == 'inventory') {
            if ($accessLevel == '1') 
            {
                $request->user()->assignRole('Admin');
                $request->user()->givePermissionTo(['view_edit_user', 'add_new_item']);
            }
            else
            {
                $request->user()->assignRole('NoneAdmin');
                $request->user()->givePermissionTo('get_add_stock');
            }
            return redirect()->route('inventory.dashboard.index');
        }
        elseif ($urlPath == 'online-exam') {
            if ($accessLevel == '1') 
            {
                $request->user()->assignRole('Admin');
                $request->user()->givePermissionTo('exam_admin_access');
            }
            else if ($accessLevel == '2') 
            {
                $request->user()->assignRole('Faculty');
                $request->user()->givePermissionTo('exam_faculty_access');
            }
            else
            {
                $request->user()->assignRole('Student');
                $request->user()->givePermissionTo('exam_student_access');
            }

            return redirect()->route('online.dashboard.index');
        }
        elseif ($urlPath == 'menu-ordering') {
            if ($accessLevel == '1') 
            {
                $request->user()->assignRole('Admin');
                $request->user()->givePermissionTo(['view_menu_order_list', 'view_menu_user_list']);
            }
            else
            {
                $request->user()->assignRole('Customer');
                $request->user()->givePermissionTo(['create_menu_orders', 'view_menu_order_history', 'view_menu_coupon_list']);
            }
            return redirect()->route('order.dashboard.index');
        }
        elseif ($urlPath == 'payroll') {
            if ($accessLevel == '1') 
            {
                $request->user()->assignRole('Admin');
                $request->user()->givePermissionTo('payroll_admin_access');
            }
            else
            {
                $request->user()->assignRole('Employee');
                $request->user()->givePermissionTo('payroll_employee_access');
            }
            return redirect()->route('payroll.dashboard.index');
        }
    }
}
