<?php

namespace App\Http\Controllers\OnlineMenuController\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrderBurger;
use App\Models\OrderComboMeal;
use App\Models\OrderCoupon;
use App\Models\OrderBeverageName;
use App\Models\OrderBeverage;
use App\Models\OrderOrder;
use App\Models\OrderTax;
use Illuminate\Pagination\LengthAwarePaginator;

class CustomerDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $burgers = OrderBurger::select('id', 'name', 'price')->get();
        $combos = OrderComboMeal::select('id', 'name', 'price')->get();
        $beverages = OrderBeverage::with(['beveragename', 'beveragesize'])->get();
        $orders = OrderOrder::where('user_id', auth()->user()->id)->select('id')->groupBy('id')->paginate(10);
        $taxes = OrderTax::select('id', 'tax', 'percentage')->get();
        $coupons = OrderCoupon::select('id', 'code', 'discount')->paginate(10, ['*'], 'coupon');
            
        return view('menuorder.index')->with(compact('burgers', 'combos', 'beverages', 'orders', 'taxes', 'coupons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $couponId = 0; 
        $keyArr = []; 
        $valArr = []; 
        $count = 0; 
        $orderNumber = 0;
        $qty = $request->input('quantity');

        $coupon = OrderCoupon::where('code', $request->input('code'))->select('id')->get();

        if (OrderOrder::exists()) {
            $orderNumber = OrderOrder::select('order_number')->max('order_number') + 1;
        
        } else { 
            $orderNumber = 1000;
        }

        if ($coupon->count() > 0) {
            $couponId = intval($coupon[0]['id']);
        }
        
        foreach ($qty as $key => $value) {
            $keyArr = explode('_', $key);
            $valArr = explode('_', $value);

            $createOrder = OrderOrder::create([
                'order_number' => $orderNumber,
                'user_id' => $request->user()->id,
                'item_id' => intval($keyArr[1]),
                'item_qty' => intval($valArr[0]),
                'item_price' => (float) $valArr[1],
                'order_coupon_id' => $couponId,
            ]);

            if ($createOrder) {
                $count++;
            }
        }

        return response()->json($orderNumber);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($category, $id)
    {
        if ($category == 'couponCheck') {
            $coupon = OrderCoupon::where('code', $id)->select('discount')->get();
            $response = $coupon->count() > 0 ? $coupon[0]->discount : 0;
            return response()->json($response);
        
        } else if ($category == 'orderPaginate') {
            $page = 1;
            $perPage = 10;
            $currentPage = $id;

            if (OrderOrder::exists()) {
                $orderA = OrderOrder::where('user_id', auth()->user()->id)->select('order_number')->distinct()->get();
                $collection = collect($orderA);

                $orders = new LengthAwarePaginator(
                    $collection->forPage($currentPage ? : $page, $perPage),
                    $collection->count(),
                    $perPage,
                    $currentPage,
                    ['path' => url()->current()]
                );
            
            } else { 
                $orders = collect(new OrderOrder); 
            }

            return view('menuorder.pagination.customer_order')->with(compact('orders'))->render();

        } else if ($category == 'couponPaginate') {
            $coupons = OrderCoupon::select('id', 'code', 'discount')->paginate(10, ['*'], 'coupon');

            return view('menuorder.pagination.order_discount')->with(compact('coupons'))->render();

        } else {
            $tax = OrderTax::select('tax', 'percentage')->get();
            $orders = OrderOrder::with('coupon')->where('order_number', $id)->get();

            if ($orders->count() > 0) {
                $order = [];
                foreach ($orders as $itemOrder) {
                    $data = [];
                    $size = '0';

                    if (intval($itemOrder->item_id) > 20000 && intval($itemOrder->item_id) < 30000) {
                        $beverage = OrderBeverage::with(['beveragename', 'beveragesize'])
                            ->where('order_beverages.id', $itemOrder->item_id)->first();

                        $item = $beverage->beveragename->name;
                        $size = $beverage->beveragesize->size;
                        $price = $itemOrder->item_price;
                    
                    } elseif (intval($itemOrder->item_id) > 30000 && intval($itemOrder->item_id) < 40000) {   
                        $combo = OrderComboMeal::find($itemOrder->item_id);
                        $item = $combo->name;
                        $price = $itemOrder->item_price;

                    } else {
                        $burger = OrderBurger::find($itemOrder->item_id);
                        $item = $burger->name;
                        $price = $itemOrder->item_price;
                    }
                    
                    $data = array('ItemName' => $item, 'ItemQty' => $itemOrder->item_qty, 'ItemSize' => $size,
                        'ItemPrice' => $price, 'CouponCode' => $itemOrder->coupon->code ?? 0, 'Discount' => $itemOrder->coupon->discount ?? 0);

                    array_push($order, $data);
                }
            }
            
            return view('menuorder.template.order_details')->with(compact('order', 'tax'))->render();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
