<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InventoryController\DashboardController;
use App\Http\Controllers\InventoryController\ProductController;
use App\Http\Controllers\InventoryController\EmployeeController;
use App\Http\Controllers\OnlineExamController\UserProfileController;
use App\Http\Controllers\OnlineExamController\AdminController;
use App\Http\Controllers\OnlineExamController\FacultyController;
use App\Http\Controllers\OnlineExamController\StudentController;
use App\Http\Controllers\OnlineMenuController\web\AdminDashboardController;
use App\Http\Controllers\OnlineMenuController\web\CustomerDashboardController;
use App\Http\Controllers\PayrollController\PayrollEmployeeController;
use App\Http\Controllers\PayrollController\PayrollAdminController;
use App\Http\Controllers\PayrollController\PayrollDashboardController;
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
		Route::get('/userpermission', [HomeController::class, 'PermissionIndex'])->name('users.permission.index');
		Route::put('/user/role/update', [HomeController::class, 'UserRoleUpdate'])->name('users.role.update');

		Route::get('/role/permission', [HomeController::class, 'RolePermissionIndex'])->name('roles.permission.index');
		Route::put('/role/permission/update', [HomeController::class, 'RolePermissionUpdate'])->name('roles.permission.update');
		Route::get('/role/permission/{name}/edit', [HomeController::class, 'RolePermissionShow'])->name('roles.permission.show');

		Route::get('/permission/user/{id}/{action}', [HomeController::class, 'UserPersmissionShow'])->name('users.permission.show');
		Route::get('/role/user/{id}/{action}', [HomeController::class, 'UserRoleShow'])->name('users.role.show');
	});
	
	/* Inventory Route */
	Route::middleware('permission:inventory add stock|inventory get stock|inventory view user|inventory edit user|inventory add new item')->prefix('inventory')->group(function() {
		Route::get('/', [DashboardController::class, 'Index'])->name('inventory.dashboard.index');
		Route::prefix('product')->group(function () {
			Route::get('/order', [ProductController::class, 'OrderIndex'])->name('inventory.order.index');
			Route::post('/order', [ProductController::class, 'OrderStore'])->name('inventory.order.store');
			Route::get('/order/{id}', [ProductController::class, 'OrderGet'])->name('inventory.order.show');

			Route::view('/deliver', 'inventory.product.receive')->name('inventory.deliver.index');
			Route::post('/deliver', [ProductController::class, 'DeliverStore'])->name('inventory.deliver.store');
			Route::get('/deliver/{id}', [ProductController::class, 'DeliverShow'])->name('inventory.deliver.show');

			Route::middleware('permission:inventory add new item')->group(function () {
				Route::get('/add', [ProductController::class, 'ProductIndex'])->name('inventory.product.index');
				Route::post('/add', [ProductController::class, 'ProductStore'])->name('inventory.product.store');
				Route::get('/view/{id}', [ProductController::class, 'ProductShow'])->name('inventory.product.show');
			});
		});	
		
		Route::prefix('employee')->group(function() {
			Route::middleware('permission:inventory view user|inventory edit user')->group(function () {
				Route::get('/logs', [EmployeeController::class, 'Index'])->name('inventory.employee.logs.index');
				Route::get('/edit', [EmployeeController::class, 'Show'])->name('inventory.employee.edit.index');

				Route::delete('/delete', [EmployeeController::class, 'Delete'])->name('inventory.employee.destroy');

				Route::put('/access/save', [EmployeeController::class, 'Store'])->name('inventory.employee.access.store');
				Route::get('/access/{id}/edit', [EmployeeController::class, 'Edit'])->name('inventory.employee.access.edit');
			});
		});
	});

	/* END */
	/* Online Exam route */
	Route::prefix('online-exam')->group(function() {
		Route::middleware('permission:exam admin access')->group(function () {
			Route::prefix('admin')->group(function () {
				Route::get('/dashboard', [AdminController::class, 'Index'])->name('online.admin.index');
				Route::get('/course', [AdminController::class, 'ShowCourse'])->name('online.course.show');
				Route::post('/course/save', [AdminController::class, 'SaveCourse'])->name('online.course.store');
				Route::put('/course/update', [AdminController::class, 'UpdateCourse'])->name('online.course.update');
				Route::delete('/user/delete', [AdminController::class, 'DeleteUser'])->name('online.user.destroy');
				Route::put('/subject/update', [AdminController::class, 'UpdateSubject'])->name('online.subject.update');
			});
		});

		Route::middleware('permission:exam faculty access')->group(function () {
			Route::prefix('faculty')->group(function () {
				Route::get('/dashboard', [FacultyController::class, 'Index'])->name('online.faculty.index');
				Route::get('/subject', [FacultyController::class, 'ShowSubject'])->name('online.subject.index');
				Route::post('/subject/save', [FacultyController::class, 'SaveSubject'])->name('online.subject.store');
				Route::get('/examination', [FacultyController::class, 'ExaminationShow'])->name('online.exam.index');
				Route::post('/examination/save', [FacultyController::class, 'ExaminationSave'])->name('online.exam.store');
				Route::post('/examination/view', [FacultyController::class, 'ExaminationView'])->name('online.exam.show');
				Route::patch('/examination/update', [FacultyController::class, 'ExaminationUpdate'])->name('online.exam.update');
				Route::get('/student/{id}/exam_score', [FacultyController::class, 'ShowScore'])->name('online.faculty.student.score.show');
			});
		});

		Route::middleware('permission:exam student access')->group(function () {
			Route::prefix('student')->group(function () {
				Route::get('/dashboard', [StudentController::class, 'Index'])->name('online.student.index');
				Route::post('exam', [StudentController::class, 'ShowExamination'])->name('online.student.exam.show');
				Route::post('exam/save', [StudentController::class, 'SaveExamination'])->name('online.student.exam.store');
			});
		});
		Route::patch('profile/update', [UserProfileController::class, 'Update'])->name('online.profile.update');
		Route::get('profile/{id}/edit', [UserProfileController::class, 'Show'])->name('online.profile.edit');
	});
	/* END */
	/* Online Menu route */
	Route::prefix('menu-ordering')->group(function() {
		/* Customer route */
		Route::middleware('permission:menu create orders|menu view order history|menu view coupon list')->group(function () {
			Route::resource('/menucustomer', CustomerDashboardController::class);//->only(['index', 'store']);
		});
		/* Admin Maintenance route */
		Route::middleware('permission:menu view order list|menu view user list')->group(function(){
			Route::resource('/menuadmin', AdminDashboardController::class);
		});
	});
	/* END */
	/* Payroll route */
	Route::prefix('payroll')->group(function() {
		Route::view('/notregister', 'payroll.notregister')->name('notregister.index');
		Route::middleware('validatepayrolluser')->group(function () {
			Route::middleware('permission:payroll admin access|payroll employee access')->group(function() {
				Route::view('/{name}/user/changepassword', 'payroll.changepassword')->name('payroll.password.index');
				Route::post('user/changepassword', [PayrollDashboardController::class, 'ChangePassSave'])->name('payroll.password.update');
			});

			Route::middleware('permission:payroll admin access')->group(function () {
				Route::prefix('admin')->group(function() {
					Route::get('/dashboard', [PayrollAdminController::class, 'Index'])->name('payroll.admin.index');

					Route::get('/user', [PayrollAdminController::class, 'UserIndex'])->name('payroll.admin.user.index');
					Route::post('/user/save', [PayrollAdminController::class, 'UserCreate'])->name('payroll.admin.user.store');

					Route::view('/salarygrade', 'payroll.admin.salarygrade')->name('payroll.admin.salarygrade.index');

					Route::post('/salarygrade/save', [PayrollAdminController::class, 'SalaryGradeCreate'])->name('payroll.admin.salarygrade.store');

					Route::view('/holiday', 'payroll.admin.holiday')->name('payroll.admin.holiday.index');

					Route::post('/holiday/save', [PayrollAdminController::class, 'HolidayCreate'])->name('payroll.admin.holiday.store');

					Route::view('/addition', 'payroll.admin.addition')->name('payroll.admin.addition.index');
					
					Route::post('/addition/save', [PayrollAdminController::class, 'AdditionCreate'])->name('payroll.admin.addition.store');

					Route::view('/deduction', 'payroll.admin.deduction')->name('payroll.admin.deduction.index');
					
					Route::post('/deduction/save', [PayrollAdminController::class, 'DeductionCreate'])->name('payroll.admin.deduction.store');

					Route::view('/workschedule', 'payroll.admin.workschedule')->name('payroll.admin.schedule.index');
					
					Route::post('/workschedule/save', [PayrollAdminController::class, 'ScheduleCreate'])->name('payroll.admin.schedule.store');

					Route::get('/cutoff/edit', [PayrollAdminController::class, 'CutoffEdit'])->name('payroll.admin.cutoff.edit');
					Route::put('/cutoff/update', [PayrollAdminController::class, 'CutoffUpdate'])->name('payroll.admin.cutoff.update');

					Route::get('/attendancerequest', [PayrollAdminController::class, 'AttendanceRequestIndex'])->name('payroll.admin.requestchange.index');
					Route::patch('/attendancerequest/action', [PayrollAdminController::class, 'RequestAction'])->name('payroll.admin.requestchange.update');

					Route::post('/salary/compute', [PayrollAdminController::class, 'ComputeSalary'])->name('payroll.admin.salary.store');

					Route::get('/workschedule/{id}/edit', [PayrollAdminController::class, 'ScheduleEdit'])->name('payroll.admin.schedule.edit');
					Route::get('/deduction/{id}/edit', [PayrollAdminController::class, 'DeductionEdit'])->name('payroll.admin.deduction.edit');
					Route::get('/addition/{id}/edit', [PayrollAdminController::class, 'AdditionEdit'])->name('payroll.admin.addition.edit');
					Route::get('/holiday/{id}/edit', [PayrollAdminController::class, 'HolidayEdit'])->name('payroll.admin.holiday.edit');
					Route::get('/salarygrade/{id}/edit', [PayrollAdminController::class, 'SalaryGradeEdit'])->name('payroll.admin.salarygrade.edit');
					Route::get('/user/{id}/edit', [PayrollAdminController::class, 'UserEdit'])->name('payroll.admin.user.edit');
				});
			});

			Route::middleware('permission:payroll employee access')->group(function () {
				Route::prefix('employee')->group(function() {
					Route::get('/dashboard', [PayrollEmployeeController::class, 'Index'])->name('payroll.employee.index');

					Route::get('/dashboard/attendance', [PayrollEmployeeController::class, 'GetAttendance'])->name('payroll.employee.attendance.show');
					
					Route::get('/dtr', [PayrollEmployeeController::class, 'Dtr'])->name('payroll.employee.dtr.index');
					Route::post('/dtr/save', [PayrollEmployeeController::class, 'DtrSave'])->name('payroll.employee.dtr.create');
					Route::post('/dtr/createrequest', [PayrollEmployeeController::class, 'DTRRequestCreate'])->name('payroll.employee.dtr.request.create');

					Route::get('/payslip/view', [PayrollEmployeeController::class, 'ViewPayslip'])->name('payroll.employee.payslip.index');
					Route::post('/payslip/view', [PayrollEmployeeController::class, 'ViewPayslip'])->name('payroll.employee.payslip.show');
					
					Route::get('/dtr/{id}/edit', [PayrollEmployeeController::class, 'DTRChangeRequest'])->name('payroll.employee.dtr.edit');
				});
			});
		});
	});
});
/* END */
