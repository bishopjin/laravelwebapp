<?php

namespace App\Http\Controllers\OnlineMenuController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Burgers;
use App\Models\ComboMeals;
use App\Models\Coupon;
use App\Models\BeveragesName;
use App\Models\Beverages;
use App\Models\Order;
use App\Models\Tax;

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
        if (Tax::exists())
        {
            $tax = Tax::select('tax', 'percentage')->get();
        }
        else { $tax = collect(new Tax); }

        if (Burgers::exists())
        {
            $burgers = Burgers::select('id', 'name', 'price')->get();
        }
        else { $burgers = collect(new Burgers); }
        
        if (ComboMeals::exists()) 
        {
            $combos = ComboMeals::select('id', 'name', 'price')->get();
        }
        else { $combos = collect(new ComboMeals); }

        if (BeveragesName::exists()) 
        {
            $beverages = DB::table('beverages')
                ->join('beverages_names', 'beverages.beverages_names_id', '=', 'beverages_names.id')
                ->join('beverages_sizes', 'beverages.beverages_sizes_id', '=', 'beverages_sizes.id')
                ->select('beverages_names.name', 'beverages_sizes.size', 'beverages.price', 'beverages.id')->get();
        }
        else { $beverages = collect(new Beverages); }

        if (Order::exists()) 
        {
            $orders = Order::where('users_id', $request->user()->id)->select('order_number')->distinct()->get();
        }
        else { $orders = collect(new Order);}

        return view('home')->with(compact('burgers', 'combos', 'beverages', 'orders', 'tax'));
    }

    public function checkCoupon(Request $request, $code)
    {
        /* check voucher validity */
        $coupon = Coupon::where('code', $code)->select('discount')->get();

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
        $coupon = Coupon::where('code', $request->input('code'))->select('id', 'discount')->get();

        if (Order::exists()) 
        {
            $order_number = Order::select('order_number')->max('order_number') + 1;
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

                    $create_order = Order::create([
                        'order_number' => $order_number,
                        'users_id' => $request->user()->id,
                        'burgers_id' => $burgers_id,
                        'burgers_qty' => $burgers_qty,
                        'beverages_id' => $beverages_id,
                        'beverages_qty' => $beverages_qty,
                        'combo_meals_id' => $combo_meals_id,
                        'combo_meals_qty' => $combo_meals_qty,
                        'coupons_id' => $coupon_id,
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

        $coupons = DB::table('orders')
            ->join('coupons', 'orders.coupons_id', '=', 'coupons.id')
            ->select('coupons.code', 'coupons.discount')
            ->where('order_number', $order_number)->distinct()->get();

        $burgers = DB::table('orders')
            ->join('burgers', 'orders.burgers_id', '=', 'burgers.id')
            ->select('burgers.name', 'burgers.price', 'orders.burgers_qty')
            ->where('order_number', $order_number)->get();

        $beverages = DB::table('orders')
            ->join('beverages', 'orders.beverages_id', '=', 'beverages.id')
            ->join('beverages_names', 'beverages.beverages_names_id', '=', 'beverages_names.id')
            ->join('beverages_sizes', 'beverages.beverages_sizes_id', '=', 'beverages_sizes.id')
            ->select('beverages_names.name', 'beverages.price', 'orders.beverages_qty', 'beverages_sizes.size')
            ->where('order_number', $order_number)->get();

        $combos = DB::table('orders')
            ->join('combo_meals', 'orders.combo_meals_id', '=', 'combo_meals.id')
            ->select('combo_meals.name', 'combo_meals.price', 'orders.combo_meals_qty')
            ->where('order_number', $order_number)->get();

        if (Tax::exists())
        {
            $tax = Tax::select('tax', 'percentage')->get();
        }
        else { $tax = collect(new Tax); }

        $merged = $burgers->merge($beverages);
        $merged2 = $merged->merge($combos);
        $merged3 = $merged2->merge($tax);
        $merged4 = $merged3->merge($coupons);

        $result = $merged4->all();

        return response()->json($result);
    }
}
