<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OnlineMenuController\MenuController;
use App\Http\Controllers\InventoryController\DashboardController;
use App\Http\Controllers\InventoryController\ProductController;
use App\Http\Controllers\InventoryController\EmployeeController;
use Illuminate\Support\Facades\Validator;
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
//Route::apiResource('', );
/* REST API login */
Route::post('/login', function(Request $request) 
{
	$response = array('role' => [], 'token' => 'Access Denied', 'id' => 0, 'permission' => []);

	$user = User::withTrashed()->where('username', $request->input('uname'))->first();
	if ($user) 
	{
		if (Hash::check($request->input('pword'), $user->password)) 
		{
			if (!$user->trashed())  {
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
		    else
	    	{
	    		$response = array('role' => [], 'token' => 'User is not active', 'id' => 0, 'permission' => []);
	    	}
		}
	}

	return response()->json($response);
});
/* register */
Route::post('/register', function(Request $request)
{
	$response = array('id' => '0', 'msg' => array('message' => 'Failed'));

	$validator = Validator::make($request->all(), [
        'username' => ['required', 'string', 'max:255', 'unique:users'],
        'password' => ['required', 'string', 'min:8'],
        'firstname' => ['required', 'string', 'max:255'],
        'lastname' => ['required', 'string', 'max:255'],
        'gender_id' => ['required', 'string', 'max:1'],
        'email' => ['required', 'email', 'unique:users'],
        'DOB' => ['date'],
    ]);

    if (!$validator->fails()) 
    {
        $user = User::create([
			'username' => $request->input('username'),
			'password' => Hash::make($request->input('password')),
			'firstname' => $request->input('firstname'),
			'middlename' => $request->input('middlename') ?? NULL,
			'email' => $request->input('email'),
			'lastname' => $request->input('lastname'),
			'gender_id' => $request->input('gender_id'),
			'DOB' => $request->input('DOB'),
		]);
        $response = array('id' => $user->id > 0 ?  '1' : '0', 'msg' => array('message' => 'Successful'));
    }
    else {
    	$response = array('id' => '2', 'msg' => array('message' => response()->json($validator->errors(), 500)));
    }
    return $response;
});
/**/
Route::middleware('auth:sanctum')->group(function () {
	/* get user id by token */
	Route::get('/checkUser', function (Request $request) {
		return auth('sanctum')->user()->id;
	});

	Route::post('/logout', function (Request $request) {
		$request->user()->currentAccessToken()->delete();
		return response()->json(['message' => 'User\'s Logged out.']);
	});
	/* inventory route */
	Route::middleware('permission:inventory add stock|inventory get stock|inventory add new item')->prefix('/inventory')->group(function() {
		Route::post('/addStock/store', [ProductController::class, 'DeliverStore']);
		Route::post('/getStock/store', [ProductController::class, 'OrderStore']);
		Route::post('/product/store', [ProductController::class, 'ProductStoreApi']);
		Route::get('/employeelogs/index', [ProductController::class, 'OrderIndexApi']);
		Route::get('/orders/index', [ProductController::class, 'OrderIndexApi']);
		Route::get('/product/index', [ProductController::class, 'ProductIndexApi']);
		Route::get('/index', [DashboardController::class, 'IndexApi']);
		Route::get('/get/{id}', [ProductController::class, 'ProductShowApi']);

		Route::prefix('/employee')->group(function() {
			Route::middleware('permission:inventory view user|inventory edit user')->group(function () {
				Route::get('/logs', [EmployeeController::class, 'IndexApi']);
				Route::get('/edit', [EmployeeController::class, 'ShowApi']);
				Route::delete('/delete', [EmployeeController::class, 'DeleteApi']);

				Route::put('/access/save', [EmployeeController::class, 'Store']);
				Route::get('/access/{id}/edit', [EmployeeController::class, 'Edit']);
			});
		});
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
