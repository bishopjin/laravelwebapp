<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersPermissionController;
use App\Http\Controllers\UsersRoleController;
use App\Http\Controllers\InventoryController\web\DashboardController;
use App\Http\Controllers\InventoryController\web\ProductController;
use App\Http\Controllers\InventoryController\web\EmployeeController;
use App\Http\Controllers\InventoryController\web\EmployeeLogsController;
use App\Http\Controllers\InventoryController\web\ItemBrandController;
use App\Http\Controllers\InventoryController\web\ItemCategoryController;
use App\Http\Controllers\InventoryController\web\ItemColorController;
use App\Http\Controllers\InventoryController\web\ItemSizeController;
use App\Http\Controllers\InventoryController\web\ItemTypeController;

use App\Http\Controllers\OnlineExamController\web\ProfileController;
use App\Http\Controllers\OnlineExamController\web\admin\AdminExamController;
use App\Http\Controllers\OnlineExamController\web\admin\AdminExamCourseController;
use App\Http\Controllers\OnlineExamController\web\faculty\FacultyExamDashboardController;
use App\Http\Controllers\OnlineExamController\web\faculty\ExamController;
use App\Http\Controllers\OnlineExamController\web\faculty\SubjectController;
use App\Http\Controllers\OnlineExamController\web\faculty\ExamQuestionController;
use App\Http\Controllers\OnlineExamController\web\student\StudentExamController;

use App\Http\Controllers\OnlineMenuController\web\AdminDashboardController;
use App\Http\Controllers\OnlineMenuController\web\CustomerDashboardController;

use App\Http\Controllers\PayrollController\web\admin\AdminPayrollDashboardController;
use App\Http\Controllers\PayrollController\web\admin\ScheduleController;
use App\Http\Controllers\PayrollController\web\admin\CutOffController;
use App\Http\Controllers\PayrollController\web\admin\AttendanceCorrectionController;
use App\Http\Controllers\PayrollController\web\admin\HolidayController;
use App\Http\Controllers\PayrollController\web\admin\SalaryAdditionController;
use App\Http\Controllers\PayrollController\web\admin\SalaryDeductionController;
use App\Http\Controllers\PayrollController\web\admin\SalaryGradeController;
use App\Http\Controllers\PayrollController\web\admin\UserRegistrationController;

use App\Http\Controllers\PayrollController\web\employee\EmployeePayrollDashboardController;
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

	/* User's Role and Permission route */
	Route::middleware('role:Super Admin')->group(function () {
		Route::resource('userspermission', UsersPermissionController::class);
		Route::resource('usersrole', UsersRoleController::class);
	});
	/* End */

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
			Route::resource('size', ItemSizeController::class);
			Route::resource('color', ItemColorController::class);
			Route::resource('brand', ItemBrandController::class);
			Route::resource('type', ItemTypeController::class);
			Route::resource('category', ItemCategoryController::class);

			Route::view('/deliver', 'inventory.product.receive')->name('deliver.index');
			Route::view('/order', 'inventory.product.order')->name('order.index');
		});	
		
		Route::middleware('permission:inventory add new item')->resource('product', ProductController::class);
	});
	/* END */

	/* Online Exam route */
	Route::prefix('online-exam')->group(function() {
		Route::middleware('permission:exam admin access')->group(function () {
			Route::resource('adminexam', AdminExamController::class);
			Route::resource('courseexam', AdminExamCourseController::class);
		});

		Route::middleware('permission:exam faculty access')->group(function () {
			Route::resource('facultyexam', FacultyExamDashboardController::class);
			Route::resource('exam', ExamController::class);
			Route::resource('subjectexam', SubjectController::class);
			Route::resource('examquestion', ExamQuestionController::class);
		});

		Route::middleware('permission:exam student access')->group(function () {
			Route::resource('studentexam', StudentExamController::class);
			Route::view('/examination', 'onlineexam.student.examination');
		});

		Route::resource('profile.user', ProfileController::class);
	});
	/* END */

	/* Online Menu route */
	Route::prefix('menu-ordering')->group(function() {
		/* Customer route */
		Route::middleware('permission:menu create orders|menu view order history|menu view coupon list')->group(function () {
			Route::get('/customer', [CustomerDashboardController::class, 'index'])->name('customer.index');
		});
		/* Admin Maintenance route */
		Route::middleware('permission:menu view order list|menu view user list')->group(function(){
			Route::get('/admin', [AdminDashboardController::class, 'index'])->name('admin.index');
		});
	});
	/* END */

	/* Payroll route */
	Route::prefix('payroll')->group(function() {
		Route::view('/notregister', 'payroll.notregister')->name('notregister.index');

		/* Admin */
		Route::middleware('permission:payroll admin access')->group(function() {
			Route::resource('payrolladmin', AdminPayrollDashboardController::class);
			Route::resource('payrollschedule', ScheduleController::class);
			Route::resource('cutoff', CutOffController::class);
			Route::resource('attendancecorrection', AttendanceCorrectionController::class);
			Route::resource('holiday', HolidayController::class);
			Route::resource('salaryaddition', SalaryAdditionController::class);
			Route::resource('salarydeduction', SalaryDeductionController::class);
			Route::resource('salarygrade', SalaryGradeController::class);
			Route::resource('register', UserRegistrationController::class);
		});

		/* Employee */
		Route::middleware('permission:payroll employee access')->group(function () {
			/* Check if user is registered in payroll system */
			Route::middleware('validatepayrolluser')->group(function () {
				Route::resource('payrollemployee', EmployeePayrollDashboardController::class);
			});
		});
		Route::resource('changepassword', PayrollChangePasswordController::class);
	});
});
/* END */
