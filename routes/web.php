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
			Route::get('/', [AdminController::class, 'Index'])->name('admin.index');
			Route::get('/course', [AdminController::class, 'ShowCourse'])->name('course.show');
			Route::post('/course/save', [AdminController::class, 'SaveCourse'])->name('course.save');
			ROute::post('/course/edit', [AdminController::class, 'EditCourse'])->name('course.edit');
			Route::post('/user/delete', [AdminController::class, 'DeleteUser'])->name('user.delete');
			Route::post('/subject/delete', [AdminController::class, 'EditSubject'])->name('subject.edit');
			Route::post('profile/{id}', [UserProfileController::class, 'Save'])->name('admin.profile.save');
			Route::get('profile/{id}', [UserProfileController::class, 'Show'])->name('admin.profile.edit');
		});

		Route::prefix('faculty')->group(function () {
			Route::get('/', [FacultyController::class, 'Index'])->name('faculty.index');
			Route::get('/subject', [FacultyController::class, 'ShowSubject'])->name('subject.show');
			Route::post('/subject/save', [FacultyController::class, 'SaveSubject'])->name('subject.save');
			Route::get('/examination', [FacultyController::class, 'ExaminationShow'])->name('exam.show');
			Route::post('/examination/save', [FacultyController::class, 'ExaminationSave'])->name('exam.save');
			Route::post('/examination/view', [FacultyController::class, 'ExaminationView'])->name('exam.view');
			Route::post('/examination/update', [FacultyController::class, 'ExaminationUpdate'])->name('exam.update');
			Route::post('profile/{id}', [UserProfileController::class, 'Save'])->name('faculty.profile.save');
			Route::get('profile/{id}', [UserProfileController::class, 'Show'])->name('faculty.profile.edit');
			Route::get('/student/{id}/exam_score', [FacultyController::class, 'ShowScore'])->name('faculty.show.student.score');
		});

		Route::prefix('student')->group(function () {
			Route::get('/', [StudentController::class, 'Index'])->name('student.index');
			Route::post('exam', [StudentController::class, 'ShowExamination'])->name('student.exam');
			Route::post('exam/save', [StudentController::class, 'SaveExamination'])->name('student.exam.save');
			Route::post('profile/{id}', [UserProfileController::class, 'Save'])->name('student.profile.save');
			Route::get('profile/{id}', [UserProfileController::class, 'Show'])->name('student.profile.edit');
		});
	});
});
/* END */
/* Online Menu route */
Route::prefix('menu-ordering')->group(function() {
	Route::get('/', [MenuController::class, 'index'])->name('menu.dashboard.index');
	Route::post('/order', [MenuController::class, 'store'])->name('order.save');
	Route::get('/checkCoupon/{code}', [MenuController::class, 'checkCoupon'])->name('order.check.coupon');
	Route::get('/order/details/{order_number}', [MenuController::class, 'view'])->name('order.details.view');
});
/* END */
/* Payroll route */

/* END */
