<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiUserController;
use App\Http\Controllers\OnlineMenuController\MenuController;

use App\Http\Controllers\InventoryController\api\ApiDashboardController;
use App\Http\Controllers\InventoryController\api\ApiProductController;
use App\Http\Controllers\InventoryController\api\ApiProductDeliverController;
use App\Http\Controllers\InventoryController\api\ApiProductOrderController;
use App\Http\Controllers\InventoryController\api\ApiEmployeeController;
use App\Http\Controllers\InventoryController\api\ApiEmployeeLogsController;

use App\Http\Controllers\OnlineExamController\api\ApiProfileController;
use App\Http\Controllers\OnlineExamController\api\admin\ApiAdminExamController;
use App\Http\Controllers\OnlineExamController\api\admin\ApiAdminExamCourseController;
use App\Http\Controllers\OnlineExamController\api\faculty\ApiFacultyExamDashboardController;
use App\Http\Controllers\OnlineExamController\api\faculty\ApiExamController;
use App\Http\Controllers\OnlineExamController\api\faculty\ApiSubjectController;
use App\Http\Controllers\OnlineExamController\api\student\ApiStudentExamController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
/* REST API login */
Route::post('/login', [ApiUserController::class, 'login'])->name('login');

/* register */
Route::post('/register', [ApiUserController::class, 'register'])->name('register');
/**/

/* Protected route */
Route::middleware('auth:sanctum')->group(function () {
	/* get user id by token */
	Route::get('/checkUser', function (Request $request) {
		return auth('sanctum')->user()->id;
	});

	Route::post('/logout', [ApiUserController::class, 'logout'])->name('logout');

	/* inventory route */
	Route::middleware('permission:inventory add stock|inventory get stock|inventory add new item')->prefix('/inventory')->group(function() {
		Route::get('/', [ApiDashboardController::class, 'index']);

		Route::prefix('employee')->group(function() {
			Route::middleware('permission:inventory view user|inventory edit user')->group(function () {
				Route::get('/employeelogs', [ApiEmployeeLogsController::class, 'index']);
				Route::apiResource('employee', ApiEmployeeController::class);
			});
		});

		Route::prefix('product')->group(function () {
			Route::apiResource('deliver', ApiProductDeliverController::class);
			Route::apiResource('order', ApiProductOrderController::class);
		});	

		Route::middleware('permission:inventory add new item')->apiResource('product', ApiProductController::class);
	});
	/* End */

	/* Online Exam route */
	Route::prefix('online-exam')->group(function() {
		Route::middleware('permission:exam admin access')->group(function () {
			Route::apiResource('adminexam', ApiAdminExamController::class);
			Route::apiResource('courseexam', ApiAdminExamCourseController::class);
		});

		Route::middleware('permission:exam faculty access')->group(function () {
			Route::apiResource('facultyexam', ApiFacultyExamDashboardController::class);
			Route::apiResource('exam', ApiExamController::class);
			Route::apiResource('subjectexam', ApiSubjectController::class);
		});

		Route::middleware('permission:exam student access')->group(function () {
			Route::apiResource('studentexam', ApiStudentExamController::class);
		});

		Route::apiResource('profile.user', ApiProfileController::class);
	});
	/* END */


	/* Customer route */
	Route::middleware('ability:menu-create-orders,menu-view-order-history,menu-view-coupon-list')->group(function () {
		Route::post('/order', [MenuController::class, 'store'])->name('order.store');
		Route::get('/customer/checkCoupon/{code}', [MenuController::class, 'show'])->name('order.coupon.show');
		Route::get('/customer/order/details/{order_number}', [MenuController::class, 'showdetails'])->name('order.details.show');
		/* paginate using ajax */
		Route::get('/customer/show/page', [MenuController::class, 'GetCustOrderPaginate'])->name('pagination.cust.order.show');
		Route::get('/customer/show/coupon', [MenuController::class, 'GetDiscountPaginate'])->name('pagination.user.coupon.show');
	});
	/* Admin Maintenance route */
	Route::middleware('ability:menu-view-order-list,menu-view-user-list')->group(function(){
		Route::post('/item/addedit', [MenuController::class, 'storeupdateitem'])->name('order.admin.item.store');
		/* paginate using ajax */
		Route::get('/admin/show/order', [MenuController::class, 'GetAdminOrderPaginate'])->name('pagination.admin.order.show');
		Route::get('/admin/show/user', [MenuController::class, 'GetAdminUserPaginate'])->name('pagination.admin.user.show');
	});
});
