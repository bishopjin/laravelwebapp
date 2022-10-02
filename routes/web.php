<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
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
			Route::prefix('customer')->group(function() {
				Route::resource('/', CustomerDashboardController::class);//->only(['index', 'store']);
			});
		});
		/* Admin Maintenance route */
		Route::middleware('permission:menu view order list|menu view user list')->group(function(){
			Route::prefix('admin')->group(function () {
				Route::resource('/', AdminDashboardController::class);
			});
		});
	});
	/* END */
	/* Payroll route */
	Route::prefix('payroll')->group(function() {
		Route::view('/notregister', 'payroll.notregister')->name('notregister.index');

		Route::middleware('validatepayrolluser')->group(function () {
			/* Admin */
			Route::middleware('permission:payroll admin access')->group(function() {
				Route::prefix('admin')->group(function() {
					Route::resource('/dashboard', AdminPayrollDashboardController::class)->names([
						'index' => 'payroll.admin.index',
					]);
				});
			});
			/* Employee */
			Route::middleware('permission:payroll employee access')->group(function () {
				Route::prefix('employee')->group(function() {
					Route::resource('/dashboard', EmployeePayrollDashboardController::class)->names([
						'index' => 'payroll.employee.index',
					]);
				});
			});
		});
		Route::resource('/changepassword', PayrollChangePasswordController::class)->names([
			'create' => 'changepassword.create',
			'update' => 'changepassword.update',
		]);
	});
});
/* END */
