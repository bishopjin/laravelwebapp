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
        if (OrderTax::exists())
        {
            $tax = OrderTax::select('tax', 'percentage')->get();
        }
        else { $tax = collect(new OrderTax); }

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
            $orders = OrderOrder::where('user_id', $request->user()->id)->select('order_number')->distinct()->get();
        }
        else { $orders = collect(new OrderOrder);}

        if (session('user_access') == '1')
        {
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

            if (OrderOrder::exists()) 
            {
                $ordersall = OrderOrder::select('order_number')->paginate(10);
            }
            else { $ordersall = collect(new OrderOrder);}

            return view('menuorder.maintenance')->with(compact('burgers', 'combos', 'beverages', 'ordersall', 'taxes', 'coupons'));
        }
        else 
        {
            return view('menuorder.home')->with(compact('burgers', 'combos', 'beverages', 'orders', 'tax'));
        }
    }

    public function checkCoupon(Request $request, $code)
    {
        /* check voucher validity */
        $coupon = OrderCoupon::where('code', $code)->select('discount')->get();

        if ($coupon->count() > 0) 
        {
            $response = $coupon[0]['discount'];
        }
        else { $response = false; }

        return response()->json($response);
    }

    /* save order */
    public function store(Request $request)
    {
        $coupon_id = 0; $keyArr = []; $count = 0; $orderNumber = 0;
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

            $create_order = OrderOrder::create([
                'order_number' => $order_number,
                'user_id' => $request->user()->id,
                'item_id' => intval($keyArr[1]),
                'item_qty' => intval($value),
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
        $result = [];
        
        if (OrderTax::exists())
        {
            $tax = OrderTax::select('tax', 'percentage')->get();
            array_push($result, array('TAX' => $tax));
        }
        else { $tax = collect(new OrderTax); }

        $orders = OrderOrder::select('item_qty', 'item_id', 'order_coupon_id', 'order_number', 'user_id')
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
                    $coupon = OrderCoupon::find(intval($item_order->order_coupon_id))->select('code', 'discount')->first();
                    if ($coupon->count() > 0) 
                    {
                        $coupon_code = $coupon->code;
                        $coupon_discount = $coupon->discount;
                    }
                }

                if (intval($item_order->item_id) > 20000 && intval($item_order->item_id) < 30000) 
                {
                    $beverage = OrderBeverage::find(intval($item_order->item_id))->join('order_beverage_names', 'order_beverages.order_beverage_name_id', '=', 'order_beverage_names.id')
                                    ->join('order_beverage_sizes', 'order_beverages.order_beverage_size_id', '=', 'order_beverage_sizes.id')
                                    ->select('order_beverage_names.name', 'order_beverage_sizes.size')->first();
                    $item = $beverage->name;
                    $size = $beverage->size;
                }
                elseif (intval($item_order->item_id) > 30000 && intval($item_order->item_id) < 40000) 
                {   
                    $combo = OrderComboMeal::find(intval($item_order->item_id))->select('name', 'price')->first();
                    $item = $combo->name;
                    $price = $combo->price;
                }
                else
                {
                    $burger = OrderBurger::find(intval($item_order->item_id))->select('name', 'price')->first();
                    $item = $burger->name;
                    $price = $burger->price;
                }
                
                $data = array('ItemName' => $item, 'ItemQty' => $item_order->item_qty, 'ItemSize' => $size,
                    'ItemPrice' => $price, 'CouponCode' => $coupon_code, 'Discount' => $coupon_discount);

                array_push($order, $data);
            }

            array_push($result, array('ORDER' => $order));
        }

        return response()->json($result);
    }
}
