<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersPermissionController;
use App\Http\Controllers\UsersRoleController;
use App\Http\Controllers\InventoryController\web\DashboardController;
use App\Http\Controllers\InventoryController\web\ProductController;
use App\Http\Controllers\InventoryController\web\ProductDeliverController;
use App\Http\Controllers\InventoryController\web\ProductOrderController;
use App\Http\Controllers\InventoryController\web\EmployeeController;
use App\Http\Controllers\InventoryController\web\EmployeeLogsController;

use App\Http\Controllers\OnlineExamController\web\UserProfileController;
use App\Http\Controllers\OnlineExamController\web\AdminController;
use App\Http\Controllers\OnlineExamController\web\FacultyController;
use App\Http\Controllers\OnlineExamController\web\StudentController;
use App\Http\Controllers\OnlineMenuController\web\AdminDashboardController;
use App\Http\Controllers\OnlineMenuController\web\CustomerDashboardController;

use App\Http\Controllers\PayrollController\web\admin\AdminPayrollDashboardController;
use App\Http\Controllers\PayrollController\web\employee\EmployeePayrollDashboardController;
use App\Http\Controllers\PayrollController\web\PayrollChangePasswordController;
use App\Http\Controllers\PayrollController\web\PayrollEmployeeController;
use App\Http\Controllers\PayrollController\web\PayrollAdminController;
use App\Http\Controllers\PayrollController\web\PayrollDashboardController;
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
Auth::routes();

Route::middleware(['auth', 'auth:sanctum'])->group(function () {
	Route::view('/', 'home')->name('index');

	Route::middleware('role:Super Admin')->group(function () {
		Route::resource('userspermission', UsersPermissionController::class);
		Route::resource('usersrole', UsersRoleController::class);
	});
	
	/* Inventory Route */
	Route::middleware('permission:inventory add stock|inventory get stock|inventory view user|inventory edit user|inventory add new item')->prefix('inventory')->group(function() {
		Route::get('/', [DashboardController::class, 'index'])->name('inventorydashboard.index');

		Route::prefix('employee')->group(function() {
			Route::middleware('permission:inventory view user|inventory edit user')->group(function () {
				Route::get('/employeelogs', [EmployeeLogsController::class, 'index'])->name('employeelogs.index');
				Route::resource('employee', EmployeeController::class);
			});
		});

		Route::prefix('product')->group(function () {
			Route::resource('deliver', ProductDeliverController::class);
			Route::resource('order', ProductOrderController::class);
		});	
		
		Route::middleware('permission:inventory add new item')->resource('product', ProductController::class);
	});
	/* END */
	/* Online Exam route */
	Route::prefix('online-exam')->group(function() {
		Route::middleware('permission:exam admin access')->group(function () {
			Route::resource('admin', AdminController::class);
		});

		Route::middleware('permission:exam faculty access')->group(function () {
			Route::resource('faculty', FacultyController::class);
		});

		Route::middleware('permission:exam student access')->group(function () {
			Route::resource('student', StudentController::class);
		});

		Route::patch('profile/update', [UserProfileController::class, 'Update'])->name('online.profile.update');
		Route::get('profile/{id}/edit', [UserProfileController::class, 'Show'])->name('online.profile.edit');
	});
	/* END */
	/* Online Menu route */
	Route::prefix('menu-ordering')->group(function() {
		/* Customer route */
		Route::middleware('permission:menu create orders|menu view order history|menu view coupon list')->group(function () {
			Route::resource('customer', CustomerDashboardController::class);//->only(['index', 'store']);
		});
		/* Admin Maintenance route */
		Route::middleware('permission:menu view order list|menu view user list')->group(function(){
			Route::resource('admin', AdminDashboardController::class);
		});
	});
	/* END */
	/* Payroll route */
	Route::prefix('payroll')->group(function() {
		Route::view('/notregister', 'payroll.notregister')->name('notregister.index');

		Route::middleware('validatepayrolluser')->group(function () {
			/* Admin */
			Route::middleware('permission:payroll admin access')->group(function() {
				Route::resource('admin', AdminPayrollDashboardController::class);
			});
			/* Employee */
			Route::middleware('permission:payroll employee access')->group(function () {
				Route::resource('employee', EmployeePayrollDashboardController::class);
			});
		});
		Route::resource('changepassword', PayrollChangePasswordController::class);
	});
});
/* END */
