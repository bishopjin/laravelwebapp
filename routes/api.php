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
/* REST API login */
Route::post('/login', function(Request $request) {
	$response = array('role' => [], 'token' => 'Access Denied', 'id' => 0, 'permission' => []);

	$user = User::where('username', $request->input('uname'))->first();
	if ($user) 
	{
		if (Hash::check($request->input('pword'), $user->password)) 
		{
			$permissions = [];
			if ($user->getPermissionsViaRoles()->count() > 0) 
			{
				foreach ($user->getPermissionsViaRoles() as $permission) 
				{
					array_push($permissions, $permission->name);
				}
			}
			//$response = $user->createToken($request->input('origin'), ['menu-view-coupon-list'])->plainTextToken;
			$response = array('role' => $user->getRoleNames(), 'token' => $user->createToken($request->input('origin'), $permissions)->plainTextToken, 'id' => $user->id, 'permission' => $permissions);
		}
	}

	return response()->json($response);
});
/**/
Route::middleware('auth:sanctum')->group(function () {
	Route::post('/logout', function (Request $request) {
		$request->user()->currentAccessToken()->delete();
		return response()->json(['message' => 'User\'s Logged out.']);
	});
	/* inventory route */
	Route::middleware('permission:inventory add stock|inventory get stock|inventory view user|inventory edit user|inventory add new item')->prefix('/inventory')->group(function() {
		Route::post('/addStock/store', [ProductController::class, 'DeliverStore']);
		Route::post('/getStock/store', [ProductController::class, 'OrderStore']);
		Route::get('/index', [DashboardController::class, 'IndexApi']);
		Route::get('/get/{id}', [ProductController::class, 'ProductShowApi']);
	});
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
