<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OnlineMenuController\MenuController;
use App\Http\Controllers\InventoryController\DashboardController;
use App\Http\Controllers\InventoryController\ProductController;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

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
Route::post('/login', function(Request $request) {
	$response = array('access' => '0', 'token' => 'Access Denied');
	
	$user = User::where('username', $request->input('uname'))->first();
	if ($user) 
	{
		if (Hash::check($request->input('pword'), $user->password)) 
		{
			//$response = $user->createToken($request->input('origin'), ['menu-view-coupon-list'])->plainTextToken;
			$response = array('access' => '1', 'token' => $user->createToken($request->input('origin'))->plainTextToken);
		}
	}

	return response()->json($response);
});

Route::middleware('auth:sanctum')->group(function () {
	Route::post('/logout', function (Request $request) {
		$request->user()->currentAccessToken()->delete();
		return response()->json(['message' => 'User\'s Logged out.']);
	});
	/* inventory route */
	Route::post('/inventory/addStock/store', [ProductController::class, 'DeliverStore']);
	Route::get('/inventory/index', [DashboardController::class, 'IndexApi']);
	Route::get('/inventory/get/{id}', [ProductController::class, 'ProductShowApi']);
	/* End */
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
