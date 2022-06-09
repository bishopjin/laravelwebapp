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
use App\Http\Controllers\OnlineExamController\ExamController;
use App\Http\Controllers\OnlineMenuController\MenuController;
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
/* test for sub-domain */
Route::domain('testweb.genesedan.com')->group(function () {

});

Auth::routes();

/* for testing only */
//Route::get('/', function() { return view('home'); });

Route::get('/', [HomeController::class, 'Index'])->name('home');
Route::get('/{urlPath}/{accessLevel}', [HomeController::class, 'AppAccess'])->name('app.access');

/* Inventory Route */
Route::prefix('inventory')->group(function() {
	Route::get('/', [DashboardController::class, 'Index'])->name('inventory.dashboard.index');
	Route::prefix('product')->group(function () {
		Route::get('/order', [ProductController::class, 'OrderAdd'])->name('inventory.order.index');
		Route::post('/order', [ProductController::class, 'OrderSave'])->name('inventory.order.create');
		Route::post('/show', [ProductController::class, 'OrderGet'])->name('inventory.order.show');
		Route::get('/deliver', [ProductController::class, 'DeliverReceive'])->name('inventory.deliver.index');
		Route::post('/deliver', [ProductController::class, 'DeliverSave'])->name('inventory.deliver.create');

		Route::middleware('checkAccessLevel_inventory')->group(function () {
			Route::get('/add', [ProductController::class, 'Index'])->name('inventory.product.index');
			Route::post('/add', [ProductController::class, 'Save'])->name('inventory.product.create');
			Route::get('/view/{id}', [ProductController::class, 'View'])->name('inventory.product.view');
		});
	});	
	
	Route::prefix('employee')->group(function() {
		Route::middleware('checkAccessLevel_inventory')->group(function () {
			Route::get('/show', [EmployeeController::class, 'Index'])->name('inventory.employee.index');
			Route::get('/edit', [EmployeeController::class, 'Edit'])->name('inventory.employee.edit');

			Route::post('/delete', [EmployeeController::class, 'DeactivateUser'])->name('inventory.employee.delete');

			Route::post('/edit/access', [EmployeeController::class, 'EditAccessSave'])->name('inventory.employee.save.access');
			Route::get('/edit/access/{id}', [EmployeeController::class, 'EditAccess'])->name('inventory.employee.edit.access');
		});
	});
});

/* END */
/* Online Exam route */
Route::middleware(['auth', 'checkaccesslevel'])->group(function () {
	Route::prefix('online-exam')->group(function() {
		Route::get('/', [ExamController::class, 'Index'])->name('online.dashboard.index');
		Route::prefix('admin')->group(function () {
			Route::get('/dashboard', [AdminController::class, 'Index'])->name('online.admin.index');
			Route::get('/course', [AdminController::class, 'ShowCourse'])->name('online.course.show');
			Route::post('/course/save', [AdminController::class, 'SaveCourse'])->name('online.course.save');
			ROute::post('/course/edit', [AdminController::class, 'EditCourse'])->name('online.course.edit');
			Route::post('/user/delete', [AdminController::class, 'DeleteUser'])->name('online.user.delete');
			Route::post('/subject/delete', [AdminController::class, 'EditSubject'])->name('online.subject.edit');
			Route::post('profile/{id}', [UserProfileController::class, 'Save'])->name('online.admin.profile.save');
			Route::get('profile/{id}', [UserProfileController::class, 'Show'])->name('online.admin.profile.edit');
		});

		Route::prefix('faculty')->group(function () {
			Route::get('/dashboard', [FacultyController::class, 'Index'])->name('online.faculty.index');
			Route::get('/subject', [FacultyController::class, 'ShowSubject'])->name('online.subject.show');
			Route::post('/subject/save', [FacultyController::class, 'SaveSubject'])->name('online.subject.save');
			Route::get('/examination', [FacultyController::class, 'ExaminationShow'])->name('online.exam.show');
			Route::post('/examination/save', [FacultyController::class, 'ExaminationSave'])->name('online.exam.save');
			Route::post('/examination/view', [FacultyController::class, 'ExaminationView'])->name('online.exam.view');
			Route::post('/examination/update', [FacultyController::class, 'ExaminationUpdate'])->name('online.exam.update');
			Route::post('profile/{id}', [UserProfileController::class, 'Save'])->name('online.faculty.profile.save');
			Route::get('profile/{id}', [UserProfileController::class, 'Show'])->name('online.faculty.profile.edit');
			Route::get('/student/{id}/exam_score', [FacultyController::class, 'ShowScore'])->name('online.faculty.show.student.score');
		});

		Route::prefix('student')->group(function () {
			Route::get('/dashboard', [StudentController::class, 'Index'])->name('online.student.index');
			Route::post('exam', [StudentController::class, 'ShowExamination'])->name('online.student.exam');
			Route::post('exam/save', [StudentController::class, 'SaveExamination'])->name('online.student.exam.save');
			Route::post('profile/{id}', [UserProfileController::class, 'Save'])->name('online.student.profile.save');
			Route::get('profile/{id}', [UserProfileController::class, 'Show'])->name('online.student.profile.edit');
		});
	});
});
/* END */
/* Online Menu route */
Route::prefix('menu-ordering')->group(function() {
	/* Admin and Customer route */
	Route::get('/', [MenuController::class, 'index'])->name('order.dashboard.index');
	/* Customer route */
	Route::post('/order', [MenuController::class, 'store'])->name('order.save');
	Route::get('/checkCoupon/{code}', [MenuController::class, 'checkCoupon'])->name('order.check.coupon');
	Route::get('/order/details/{order_number}', [MenuController::class, 'view'])->name('order.details.view');

	/* Admin Maintenance route */
	Route::post('/item/add', [MenuController::class, 'AddItem'])->name('order.admin.add');
	Route::post('/item/edit', [MenuController::class, 'EditItem'])->name('order.admin.edit');
	/* paginate using ajax */
	Route::get('/show/page', [MenuController::class, 'GetCustOrderPaginate'])->name('pagination.cust.order');
	Route::get('/show/admin/order', [MenuController::class, 'GetAdminOrderPaginate'])->name('pagination.admin.order');
	Route::get('/show/admin/user', [MenuController::class, 'GetAdminUserPaginate'])->name('pagination.admin.user');
	Route::get('/show/coupon', [MenuController::class, 'GetDiscountPaginate'])->name('pagination.user.coupon');
});
/* END */
/* Payroll route */
Route::middleware(['auth', 'checkaccesslevelpayroll'])->group(function() {
	Route::prefix('payroll')->group(function() {
		Route::get('/', [PayrollDashboardController::class, 'Index'])->name('payroll.dashboard.index');
		
		Route::prefix('admin')->group(function() {
			Route::get('/dashboard', [PayrollAdminController::class, 'Index'])->name('payroll.admin.index');

			Route::get('/user', [PayrollAdminController::class, 'UserIndex'])->name('payroll.admin.user.index');
			Route::post('/user/save', [PayrollAdminController::class, 'UserCreate'])->name('payroll.admin.user.create');

			Route::get('/changepassword', [PayrollDashboardController::class, 'ChangePassIndex'])->name('payroll.admin.password.index');
			Route::post('/changepassword', [PayrollDashboardController::class, 'ChangePassSave'])->name('payroll.admin.password.create');

			Route::get('/salarygrade', [PayrollAdminController::class, 'SalaryGradeIndex'])->name('payroll.admin.salarygrade.index');
			Route::post('/salarygrade/save', [PayrollAdminController::class, 'SalaryGradeCreate'])->name('payroll.admin.salarygrade.create');

			Route::get('/holiday', [PayrollAdminController::class, 'HolidayIndex'])->name('payroll.admin.holiday.index');
			Route::post('/holiday/save', [PayrollAdminController::class, 'HolidayCreate'])->name('payroll.admin.holiday.create');

			Route::get('/addition', [PayrollAdminController::class, 'AdditionIndex'])->name('payroll.admin.addition.index');
			Route::post('/addition/save', [PayrollAdminController::class, 'AdditionCreate'])->name('payroll.admin.addition.create');

			Route::get('/deduction', [PayrollAdminController::class, 'DeductionIndex'])->name('payroll.admin.deduction.index');
			Route::post('/deduction/save', [PayrollAdminController::class, 'DeductionCreate'])->name('payroll.admin.deduction.create');

			Route::get('/deduction/edit/{id}', [PayrollAdminController::class, 'DeductionEdit'])->name('payroll.admin.deduction.edit');
			Route::get('/addition/edit/{id}', [PayrollAdminController::class, 'AdditionEdit'])->name('payroll.admin.addition.edit');
			Route::get('/holiday/edit/{id}', [PayrollAdminController::class, 'HolidayEdit'])->name('payroll.admin.holiday.edit');
			Route::get('/salarygrade/edit/{id}', [PayrollAdminController::class, 'SalaryGradeEdit'])->name('payroll.admin.salarygrade.edit');
			Route::get('/user/edit/{id}', [PayrollAdminController::class, 'UserEdit'])->name('payroll.admin.user.edit');
		});

		Route::prefix('employee')->group(function() {
			Route::get('/dashboard', [PayrollEmployeeController::class, 'Index'])->name('payroll.employee.index');

			Route::get('/changepassword', [PayrollDashboardController::class, 'ChangePassIndex'])->name('payroll.employee.password.index');
			Route::post('/changepassword', [PayrollDashboardController::class, 'ChangePassSave'])->name('payroll.employee.password.create');
		});
	});
});
/* END */
