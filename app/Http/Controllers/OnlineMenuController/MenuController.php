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
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
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
            $beverages = OrderBeverage::with(['beveragename', 'beveragesize'])->get();
        }
        else { $beverages = collect(new OrderBeverage); }

        if (OrderOrder::exists()) 
        {
            $orders = OrderOrder::where('user_id', $request->user()->id)->select('order_number')
                ->groupBy('order_number')->paginate(10);
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

        if ($request->user()->can('view_menu_order_list') AND $request->user()->can('view_menu_user_list'))
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

    public function show(Request $request, $code)
    {
        /* check voucher validity */
        $coupon = OrderCoupon::where('code', $code)->select('discount')->get();

        $response = $coupon->count() > 0 ? $coupon[0]->discount : false;
        
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

            if ($create_order) 
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

    public function showdetails(Request $request, $order_number)
    {
        if (OrderTax::exists())
        {
            $tax = OrderTax::select('tax', 'percentage')->get();
        }
        else { $tax = collect(new OrderTax); }

        $orders = OrderOrder::with('coupon')->where('order_number', $order_number)->get();

        if ($orders->count() > 0) 
        {
            $order = [];
            foreach ($orders as $item_order) {
                $data = [];
                $size = '0';

                if (intval($item_order->item_id) > 20000 && intval($item_order->item_id) < 30000) 
                {
                    $beverage = OrderBeverage::with(['beveragename', 'beveragesize'])
                                ->where('order_beverages.id', $item_order->item_id)->first();

                    $item = $beverage->beveragename->name;
                    $size = $beverage->beveragesize->size;
                    $price = $item_order->item_price;
                }
                elseif (intval($item_order->item_id) > 30000 && intval($item_order->item_id) < 40000) 
                {   
                    $combo = OrderComboMeal::find($item_order->item_id);
                    $item = $combo->name;
                    $price = $item_order->item_price;
                }
                else
                {
                    $burger = OrderBurger::find($item_order->item_id);
                    $item = $burger->name;
                    $price = $item_order->item_price;
                }
                
                $data = array('ItemName' => $item, 'ItemQty' => $item_order->item_qty, 'ItemSize' => $size,
                    'ItemPrice' => $price, 'CouponCode' => $item_order->coupon->code ?? 0, 'Discount' => $item_order->coupon->discount ?? 0);

                array_push($order, $data);
            }
        }
        return view('menuorder.template.order_details')->with(compact('order', 'tax'))->render();
    }

    /* Admin Maintenance Controller */
    public function storeupdateitem(Request $request) 
    {
        //$item_id = intval($request->input('id'));
        $item_name = $request->input('param1');
        $item_size_price = (float) $request->input('param2');
        $item_price = (float) $request->input('param3');

        switch ($request->input('param0')) 
        {
            case 'burger':
                $result = OrderBurger::updateOrCreate(
                    ['name' => $item_name],
                    ['price' => $item_size_price]
                );

                break;

            case 'beverage':
                    $recordAdded = false;

                    $check = OrderBeverageName::where('name', $item_name)->select('id')->get();

                    if ($check->count() == 0)
                    {
                        $create_record_name = OrderBeverageName::create(['name' => $item_name]);
                        $recordAdded = $create_record_name->id > 0 ? true : false;
                    }
                    
                    $create_record = OrderBeverage::updateOrCreate(
                        [
                            'order_beverage_name_id' => $recordAdded ? $create_record_name->id : $check[0]->id,
                            'order_beverage_size_id' => intval($item_size_price)
                        ],
                        ['price' => $item_price]
                    );

                    $result = OrderBeverage::with(['beveragename', 'beveragesize'])->find($create_record->id);
                break;

            case 'combo':
                $result = OrderComboMeal::updateOrCreate(
                    ['name' => $item_name],
                    ['price' => $item_size_price]
                );

                break;

            case 'tax':
                $result = OrderTax::updateOrCreate(
                    ['tax' => $item_name],
                    ['percentage' => ($item_size_price / 100)]
                );

                break;

            default:
                $result = OrderCoupon::updateOrCreate(
                    ['code' => $item_name],
                    ['discount' => ($item_size_price / 100)]
                );
        }
        return response()->json($result);
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
        $userprofile = User::with('gender')->paginate(10, ['*'], 'user');

        return $userprofile;
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
                    $orderCoupon = OrderCoupon::find(intval($order->order_coupon_id));
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
