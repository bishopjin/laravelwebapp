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

        return view('home')->with(compact('burgers', 'combos', 'beverages', 'orders', 'tax'));
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
        $discount = 0; $coupon_id = 0;
        $data = $request->input('order');
        $qty = $request->input('quantity');

        /* check voucher validity */
        $coupon = OrderCoupon::where('code', $request->input('code'))->select('id', 'discount')->get();

        if (OrderOrder::exists()) 
        {
            $order_number = OrderOrder::select('order_number')->max('order_number') + 1;
        }
        else { $order_number = 1000;}

        if ($coupon->count() > 0) 
        {
            $coupon_id = intval($coupon[0]['id']);
            $discount = floatval($coupon[0]['discount']);
        }
        
        foreach ($data as $item) {
            $val_arr = explode('_', $item);

            foreach ($qty as $key => $value) {
                if ($item === $key) 
                {
                    $burgers_id = 0;
                    $burgers_qty = 0;
                    $beverages_id = 0;
                    $beverages_qty = 0;
                    $combo_meals_id = 0;
                    $combo_meals_qty = 0;

                    if (str_contains($key, 'burger')) 
                    {
                        $burgers_id = intval($val_arr[1]);
                        $burgers_qty = intval($value);
                    }
                    else if (str_contains($key, 'beverage')) 
                    {
                        $beverages_id = $val_arr[1];
                        $beverages_qty = intval($value);
                    }
                    else
                    {
                        $combo_meals_id = $val_arr[1];
                        $combo_meals_qty = intval($value);
                    }

                    $create_order = OrderOrder::create([
                        'order_number' => $order_number,
                        'user_id' => $request->user()->id,
                        'order_burger_id' => $burgers_id,
                        'burgers_qty' => $burgers_qty,
                        'order_beverage_id' => $beverages_id,
                        'beverages_qty' => $beverages_qty,
                        'order_combo_meal_id' => $combo_meals_id,
                        'combo_meals_qty' => $combo_meals_qty,
                        'order_coupon_id' => $coupon_id,
                    ]);

                    if ($create_order->id > 0)
                    {
                        $response = $create_order->order_number;
                    }
                    else { $response = 0; }
                    break;
                }
            }
        }
        return response()->json($response);
    }

    public function view(Request $request, $order_number)
    {
        $result = 0;

        $coupons = OrderOrder::join('order_coupons', 'orders.order_coupon_id', '=', 'order_coupons.id')
            ->select('order_coupons.code', 'order_coupons.discount')
            ->where('order_number', $order_number)->distinct()->get();

        $burgers = OrderOrder::join('order_burgers', 'order_orders.order_burger_id', '=', 'order_burgers.id')
            ->select('order_burgers.name', 'order_burgers.price', 'order_orders.burgers_qty')
            ->where('order_number', $order_number)->get();

        $beverages = OrderOrder::join('order_beverages', 'order_orders.order_beverage_id', '=', 'order_beverages.id')
            ->join('order_beverage_names', 'order_beverages.order_beverage_name_id', '=', 'order_beverage_names.id')
            ->join('order_beverage_sizes', 'order_beverages.order_beverage_size_id', '=', 'order_beverage_sizes.id')
            ->select('order_beverage_names.name', 'order_beverages.price', 'order_orders.beverages_qty', 'order_beverage_sizes.size')
            ->where('order_number', $order_number)->get();

        $combos = OrderOrder::join('order_combo_meals', 'order_orders.order_combo_meal_id', '=', 'order_combo_meals.id')
            ->select('order_combo_meals.name', 'order_combo_meals.price', 'order_orders.combo_meals_qty')
            ->where('order_number', $order_number)->get();

        if (Tax::exists())
        {
            $tax = OrderTax::select('tax', 'percentage')->get();
        }
        else { $tax = collect(new OrderTax); }

        $merged = $burgers->merge($beverages);
        $merged2 = $merged->merge($combos);
        $merged3 = $merged2->merge($tax);
        $merged4 = $merged3->merge($coupons);

        $result = $merged4->all();

        return response()->json($result);
    }
}
