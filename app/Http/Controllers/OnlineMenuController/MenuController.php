<?php

namespace App\Http\Controllers\OnlineMenuController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrderBurger;
use App\Models\OrderComboMeal;
use App\Models\OrderCoupon;
use App\Models\OrderBeverageName;
use App\Models\OrderBeverage;
use App\Models\OrderOrder;
use App\Models\OrderTax;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

class MenuController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $page = 1;
        $perPage = 10;

        if (OrderBurger::exists())
        {
            $burgers = OrderBurger::select('id', 'name', 'price')->get();
        }
        else { $burgers = collect(new OrderBurger); }
        
        if (OrderComboMeal::exists()) 
        {
            $combos = OrderComboMeal::select('id', 'name', 'price')->get();
        }
        else { $combos = collect(new OrderComboMeal); }

        if (OrderBeverageName::exists()) 
        {
            $beverages = OrderBeverage::join('order_beverage_names', 'order_beverages.order_beverage_name_id', '=', 'order_beverage_names.id')
                ->join('order_beverage_sizes', 'order_beverages.order_beverage_size_id', '=', 'order_beverage_sizes.id')
                ->select('order_beverage_names.name', 'order_beverage_sizes.size', 'order_beverages.price', 'order_beverages.id')->get();
        }
        else { $beverages = collect(new OrderBeverage); }

        if (OrderOrder::exists()) 
        {
            $orderA = OrderOrder::where('user_id', $request->user()->id)->select('order_number')->distinct()->get();
            $collection = collect($orderA);

            $orders = new LengthAwarePaginator(
                    $collection->forPage($request->page ? : $page, $perPage),
                    $collection->count(),
                    $perPage,
                    $request->page,
                    ['path' => url()->current()]
                );
        }
        else { $orders = collect(new OrderOrder);}

        if (OrderCoupon::exists())
        {
            $coupons = OrderCoupon::select('id', 'code', 'discount')->get();
        }
        else { $coupons = collect(new OrderCoupon); }

        if (OrderTax::exists())
        {
            $taxes = OrderTax::select('id', 'tax', 'percentage')->get();
        }
        else { $taxes = collect(new OrderTax); }

        if (session('user_access') == '1')
        {
            $pagination = $this->GetAllOrder($request, $taxes);

            $users = $this->GetAllUsers();

            return view('menuorder.maintenance')->with(compact('burgers', 'combos', 'beverages', 'pagination', 'users', 'taxes', 'coupons'));
        }
        else 
        {
            $coupons = OrderCoupon::select('id', 'code', 'discount')->paginate(10, ['*'], 'coupon');
            return view('menuorder.home')->with(compact('burgers', 'combos', 'beverages', 'orders', 'taxes', 'coupons'));
        }
    }

    public function checkCoupon(Request $request, $code)
    {
        /* check voucher validity */
        $coupon = OrderCoupon::where('code', $code)->select('discount')->get();

        if ($coupon->count() > 0) 
        {
            $response = $coupon[0]->discount;
        }
        else { $response = false; }

        return response()->json($response);
    }

    /* save order */
    public function store(Request $request)
    {
        $coupon_id = 0; $keyArr = []; $valArr = []; $count = 0; $orderNumber = 0;
        $qty = $request->input('quantity');

        /* check voucher validity */
        $coupon = OrderCoupon::where('code', $request->input('code'))->select('id')->get();

        if (OrderOrder::exists()) 
        {
            $order_number = OrderOrder::select('order_number')->max('order_number') + 1;
        }
        else { $order_number = 1000;}

        if ($coupon->count() > 0) 
        {
            $coupon_id = intval($coupon[0]['id']);
        }
        
        foreach ($qty as $key => $value) 
        {
            $keyArr = explode('_', $key);
            $valArr = explode('_', $value);

            $create_order = OrderOrder::create([
                'order_number' => $order_number,
                'user_id' => $request->user()->id,
                'item_id' => intval($keyArr[1]),
                'item_qty' => intval($valArr[0]),
                'item_price' => (float) $valArr[1],
                'order_coupon_id' => $coupon_id,
            ]);

            if ($create_order->id > 0) 
            {
                $count++;
            }
        }

        if ($count > 0) 
        {
            $orderNumber = $order_number;
        }

        return response()->json($orderNumber);
    }

    public function view(Request $request, $order_number)
    {
        if (OrderTax::exists())
        {
            $tax = OrderTax::select('tax', 'percentage')->get();
        }
        else { $tax = collect(new OrderTax); }

        $orders = OrderOrder::select('item_qty', 'item_id', 'order_coupon_id', 'order_number', 'user_id', 'item_price')
            ->where('order_number', $order_number)->get();

        if ($orders->count() > 0) 
        {
            $order = [];
            foreach ($orders as $item_order) {
                $data = [];
                $coupon_code = 0;
                $coupon_discount = 0;
                $size = '0';

                if (intval($item_order->order_coupon_id) > 0)
                {
                    $coupon = OrderCoupon::where('id', intval($item_order->order_coupon_id))->select('code', 'discount')->first();
                    if ($coupon->count() > 0) 
                    {
                        $coupon_code = $coupon->code;
                        $coupon_discount = $coupon->discount;
                    }
                }

                if (intval($item_order->item_id) > 20000 && intval($item_order->item_id) < 30000) 
                {
                    $beverage = OrderBeverage::where('order_beverages.id', intval($item_order->item_id))
                                    ->join('order_beverage_names', 'order_beverages.order_beverage_name_id', '=', 'order_beverage_names.id')
                                    ->join('order_beverage_sizes', 'order_beverages.order_beverage_size_id', '=', 'order_beverage_sizes.id')
                                    ->select('order_beverage_names.name', 'order_beverage_sizes.size')
                                    ->first();
                    $item = $beverage->name;
                    $size = $beverage->size;
                    $price = $item_order->item_price;
                }
                elseif (intval($item_order->item_id) > 30000 && intval($item_order->item_id) < 40000) 
                {   
                    $combo = OrderComboMeal::where('id', intval($item_order->item_id))->select('name')->first();
                    $item = $combo->name;
                    $price = $item_order->item_price;
                }
                else
                {
                    $burger = OrderBurger::where('id', intval($item_order->item_id))->select('name')->first();
                    $item = $burger->name;
                    $price = $item_order->item_price;
                }
                
                $data = array('ItemName' => $item, 'ItemQty' => $item_order->item_qty, 'ItemSize' => $size,
                    'ItemPrice' => $price, 'CouponCode' => $coupon_code, 'Discount' => $coupon_discount);

                array_push($order, $data);
            }
        }
        return view('menuorder.template.order_details')->with(compact('order', 'tax'))->render();
    }

    /* Admin Maintenance Controller */
    public function AddItem(Request $request) 
    {
        $item_id = intval($request->input('id'));
        $item_type = $request->input('param0');
        $item_name = $request->input('param1');
        $item_size_price = (float) $request->input('param2');
        $item_price = (float) $request->input('param3');

        $result = $this->sqlQuery($item_id, $item_type, $item_price, $item_size_price, $item_name, 'AddRecord');

        return response()->json($result);
    }

    public function EditItem(Request $request)
    {
        $item_id = intval($request->input('id'));
        $item_type = $request->input('param0');
        $item_name = $request->input('param1');
        $item_size_price = (float) $request->input('param2');
        $item_price = (float) $request->input('param3');

        $result = $this->sqlQuery($item_id, $item_type, $item_price, $item_size_price, $item_name,'EditRecord');

        return response()->json($result);
    }

    /* service */
    private function sqlQuery($item_id, $item_type, $item_price, $item_size_price, $item_name, $queryType)
    {
        $recordExist = 'Record already exist.';

        switch ($item_type) 
        {
            case 'burger':
                if ($queryType == 'EditRecord') 
                {
                    $result = OrderBurger::find($item_id)->update(['price' => $item_size_price]);
                }
                else {
                    /* check if name exist */
                    $check = OrderBurger::where('name', $item_name)->get();

                    if ($check->count() > 0) 
                    {
                        $result = $recordExist;
                    }
                    else
                    {
                        /* save */
                        $create_record = OrderBurger::create([
                            'name' => $item_name,
                            'price' => $item_size_price,
                        ]);

                        $result = $create_record->id;
                    }
                }
                break;

            case 'beverage':
                if ($queryType == 'EditRecord') 
                {
                    $result = OrderBeverage::find($item_id)->update(['price' => $item_price]);
                }
                else
                {
                    $notInRecord = true;
                    $recordAdded = false;

                    $check = OrderBeverageName::where('name', $item_name)->select('id')->get();

                    if ($check->count() > 0) 
                    {
                        $findDrinks = OrderBeverage::where([
                            ['order_beverage_name_id', '=', $check[0]->id],
                            ['order_beverage_size_id', '=', $item_size_price],
                        ])->get();

                        if ($findDrinks->count() > 0) 
                        {
                            $notInRecord = false;
                        }
                    }
                    else 
                    {
                        $create_record_name = OrderBeverageName::create([
                            'name' => $item_name,
                        ]);

                        if ($create_record_name->id > 0) 
                        {
                            $recordAdded = true;
                        }
                    }
                    
                    if ($notInRecord)
                    {                            
                        $create_record = OrderBeverage::create([
                            'order_beverage_name_id' => $recordAdded ? $create_record_name->id : $check[0]->id,
                            'order_beverage_size_id' => intval($item_size_price),
                            'price' => $item_price,
                        ]);
    
                        $result = $create_record->id;
                    }
                    else
                    {
                        $result = $recordExist;
                    }
                }
                break;

            case 'combo':
                if ($queryType == 'EditRecord') 
                {
                    $result = OrderComboMeal::find($item_id)->update(['price' => $item_size_price]);
                }
                else
                {
                    $check = OrderComboMeal::where('name', $item_name)->get();

                    if ($check->count() > 0) 
                    {
                        $result = $recordExist;
                    }
                    else
                    {
                        $create_record = OrderComboMeal::create([
                            'name' => $item_name,
                            'price' => $item_size_price,
                        ]);

                        $result = $create_record->id;
                    }
                }
                break;

            case 'tax':
                if ($queryType == 'EditRecord') 
                {
                    $result = OrderTax::find($item_id)->update(['percentage' => ($item_size_price / 100)]);
                }
                else
                {
                    $check = OrderTax::where('tax', $item_name)->get();

                    if ($check->count() > 0) 
                    {
                        $result = $recordExist;
                    }
                    else
                    {
                        $create_record = OrderTax::create([
                            'tax' => $item_name,
                            'percentage' => ($item_size_price / 100),
                        ]);

                        $result = $create_record->id;
                    }
                }
                break;

            default:
                if ($queryType == 'EditRecord') 
                {
                    $result = orderCoupon::find($item_id)->update(['discount' => ($item_size_price / 100)]);
                }
                else 
                {
                    $check = OrderCoupon::where('code', $item_name)->get();

                    if ($check->count() > 0) 
                    {
                        $result = $recordExist;
                    }
                    else
                    {
                        $create_record = OrderCoupon::create([
                            'code' => $item_name,
                            'discount' => ($item_size_price / 100),
                        ]);

                        $result = $create_record->id;
                    }
                }
                break;
        }

        return $result;
    }

    /**/
    public function GetCustOrderPaginate(Request $request)
    {
        if ($request->ajax()) 
        {
            $page = 1;
            $perPage = 10;

            if (OrderOrder::exists()) 
            {
                $orderA = OrderOrder::where('user_id', $request->user()->id)->select('order_number')->distinct()->get();
                $collection = collect($orderA);

                $orders = new LengthAwarePaginator(
                        $collection->forPage($request->page ? : $page, $perPage),
                        $collection->count(),
                        $perPage,
                        $request->page,
                        ['path' => url()->current()]
                    );
            }
            else { $orders = collect(new OrderOrder); }

            return view('menuorder.pagination.customer_order')->with(compact('orders'))->render();
        }
    }

    public function GetAdminOrderPaginate(Request $request)
    {
        if ($request->ajax())
        {
            if (OrderTax::exists())
            {
                $taxes = OrderTax::select('id', 'tax', 'percentage')->get();
            }
            else { $taxes = collect(new OrderTax); }

            $pagination = $this->GetAllOrder($request, $taxes);

            return view('menuorder.pagination.admin_order')->with(compact('pagination'))->render();
        }
    }

    public function GetDiscountPaginate(Request $request)
    {
        if ($request->ajax())
        {
            $coupons = OrderCoupon::select('id', 'code', 'discount')->paginate(10, ['*'], 'coupon');

            return view('menuorder.pagination.order_discount')->with(compact('coupons'))->render();
        }
    }

    public function GetAdminUserPaginate(Request $request)
    {
        if ($request->ajax()) 
        {
            $users = $this->GetAllUsers();

            return view('menuorder.pagination.admin_user')->with(compact('users'))->render();
        }
    }

    /* services */
    private function GetAllUsers()
    {
        $users = User::join('users_profiles', 'users.id', '=', 'users_profiles.user_id')
                    ->join('genders', 'users_profiles.gender_id', '=', 'genders.id')
                    ->select('users_profiles.firstname', 'users_profiles.middlename', 'users_profiles.lastname',
                            'genders.gender', 'users.isactive')->paginate(10, ['*'], 'user');

        return $users;
    }
    private function GetAllOrder($request, $taxes)
    {
        if (OrderOrder::exists()) 
        {
            $result = [];
            $page = 1;
            $perPage = 10;
            $discount = 0;
            $subTotal = 0;
            $cur_order_no = 0;
            $count = 0;
            $tax = 0;

            $ordersall = OrderOrder::select('order_number', 'item_id', 'item_price', 'item_qty', 'order_coupon_id')->get();
            
            $orderCOunt = count($ordersall);

            if ($taxes->count() > 0) {
                foreach ($taxes as $value) {
                    $tax += $value->percentage;
                }
            }

            foreach ($ordersall as $order) {
                $count++;
                 
                if ($cur_order_no != 0 && $cur_order_no != intval($order->order_number)) 
                {   
                    array_push($result, array(
                        'OrderNumber' => $cur_order_no,
                        'Tax' => $tax,
                        'SubTotal' => $subTotal,
                        'Discount' => $discount
                    ));
                    $subTotal = 0;
                    $subTotal += intval($order->item_price) * intval($order->item_qty);
                    $cur_order_no = intval($order->order_number);
                }
                else 
                {
                    $cur_order_no = intval($order->order_number);
                    $subTotal += intval($order->item_price) * intval($order->item_qty);
                }

                if ($order->order_coupon_id > 0) 
                {   
                    $orderCoupon = OrderCoupon::find(intval($order->order_coupon_id))->first();
                    $discount = $orderCoupon->discount;
                }
                else 
                {
                    $discount = 0;
                }

                if ($count == $orderCOunt)
                {
                    array_push($result, array(
                        'OrderNumber' => $cur_order_no,
                        'Tax' => $tax,
                        'SubTotal' => $subTotal,
                        'Discount' => $discount
                    ));
                }
            }

            $collection = collect($result);

            $pagination = new LengthAwarePaginator(
                $collection->forPage($request->page ? : $page, $perPage),
                $collection->count(),
                $perPage,
                $request->page,
                ['path' => url()->current()]
            );
        }
        else { 
            $pagination = collect(new OrderOrder);
        }

        return $pagination; 
    }
}
