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
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

class AdminDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $burgers = OrderBurger::select('id', 'name', 'price')->get();
        $combos = OrderComboMeal::select('id', 'name', 'price')->get();
        $beverages = OrderBeverage::with(['beveragename', 'beveragesize'])->get();
        $orders = OrderOrder::where('user_id', auth()->user()->id)->select('order_number')->groupBy('order_number')->paginate(10);
        $coupons = OrderCoupon::select('id', 'code', 'discount')->get();
        $taxes = OrderTax::select('id', 'tax', 'percentage')->get();

        $pagination = $this->GetAllOrder($request->page, $taxes);

        $users = $this->GetAllUsers();

        return view('menuorder.maintenance')->with(compact('burgers', 'combos', 'beverages', 'pagination', 'users', 'taxes', 'coupons'));
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
        $itemName = $request->input('param1');
        $itemSizePrice = (float) $request->input('param2');
        $itemPrice = (float) $request->input('param3');

        switch ($request->input('param0')) 
        {
            case 'burger':
                $created = OrderBurger::create(['name' => $itemName, 'price' => $itemSizePrice]);

                break;

            case 'beverage':
                    $createRecordName = OrderBeverageName::create(['name' => $itemName]);
                    
                    if ($createRecordName->id > 0)
                    {
                        $created = OrderBeverage::create([
                                'order_beverage_name_id' => $createRecordName->id,
                                'order_beverage_size_id' => intval($itemSizePrice),
                                'price' => $itemPrice
                        ]);
                    }
                    else
                    {
                        $created = array('id' => 0);
                    }
                break;

            case 'combo':
                $created = OrderComboMeal::create(['name' => $itemName, 'price' => $itemSizePrice]);
                break;

            case 'tax':
                $created = OrderTax::create(['tax' => $itemName, 'percentage' => ($itemSizePrice / 100)]);
                break;

            default:
                $created = OrderCoupon::create(['code' => $itemName, 'discount' => ($itemSizePrice / 100)]);
                break;
        }
        return response()->json($created->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($category, $id)
    {
        /* for pagination users and orders */
        if ($request->ajax())
        {
            if ($category == 'user')
            {   
                $users = $this->GetAllUsers();
                return view('menuorder.pagination.admin_user')->with(compact('users'))->render();
            }
            else
            {
                $currentPage = $id;

                if (OrderTax::exists())
                {
                    $taxes = OrderTax::select('id', 'tax', 'percentage')->get();
                }
                else 
                { 
                    $taxes = collect(new OrderTax); 
                }

                $pagination = $this->GetAllOrder($currentPage, $taxes);

                return view('menuorder.pagination.admin_order')->with(compact('pagination'))->render();
            }
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($category, $id)
    {
        switch ($category) 
        {
            case 'burger':
                $data = OrderBurger::find($id);
                break;

            case 'beverage':
                $data = OrderBeverage::with(['beveragename', 'beveragesize'])->find($id);
                break;

            case 'combo':
                $data = OrderComboMeal::find($id);
                break;

            case 'tax':
                $data = OrderTax::find($id);
                break;

            default:
                $data = OrderCoupon::find($id);
                break;
        }

        return $data;
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
        $itemName = $request->input('param1');
        $itemSizePrice = (float) $request->input('param2');
        $itemPrice = (float) $request->input('param3');

        switch ($request->input('param0')) 
        {
            case 'burger':
                $result = OrderBurger::find($id)->update(['name' => $itemName, 'price' => $itemSizePrice]);

                break;

            case 'beverage':
                    $beverageNameId = OrderBeverageName::where('name', $itemName)->select('id')->get();

                    $beverage = OrderBeverage::find($id)->update([
                        'order_beverage_name_id' => $beverageNameId[0]->id,
                        'order_beverage_size_id' => intval($itemSizePrice),
                        'price' => $itemPrice
                    ]);
                break;

            case 'combo':
                $result = OrderComboMeal::find($id)->update(['name' => $itemName, 'price' => $itemSizePrice]);
                break;

            case 'tax':
                $result = OrderTax::find($id)->update(['tax' => $itemName, 'percentage' => ($itemSizePrice / 100)]);
                break;

            default:
                $result = OrderCoupon::find($id)->update(['code' => $itemName, 'discount' => ($itemSizePrice / 100)]);
                break;
        }
        return response()->json($result);
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

    /*
     * Service
    */
    private function GetAllOrder($currentPage, $taxes)
    {
        if (OrderOrder::exists()) 
        {
            $result = [];
            $page = 1;
            $perPage = 10;
            $discount = 0;
            $subTotal = 0;
            $curOrderNo = 0;
            $count = 0;
            $tax = 0;

            $ordersall = OrderOrder::select('order_number', 'item_id', 'item_price', 'item_qty', 'order_coupon_id')->get();
            
            $orderCount = count($ordersall);

            if ($taxes->count() > 0) 
            {
                foreach ($taxes as $value) 
                {
                    $tax += $value->percentage;
                }
            }

            foreach ($ordersall as $order) {
                $count++;
                 
                if ($curOrderNo != 0 && $curOrderNo != intval($order->order_number)) 
                {   
                    array_push($result, array(
                        'OrderNumber' => $curOrderNo,
                        'Tax' => $tax,
                        'SubTotal' => $subTotal,
                        'Discount' => $discount
                    ));
                    $subTotal = 0;
                    $subTotal += intval($order->item_price) * intval($order->item_qty);
                    $curOrderNo = intval($order->order_number);
                }
                else 
                {
                    $curOrderNo = intval($order->order_number);
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

                if ($count == $orderCount)
                {
                    array_push($result, array(
                        'OrderNumber' => $curOrderNo,
                        'Tax' => $tax,
                        'SubTotal' => $subTotal,
                        'Discount' => $discount
                    ));
                }
            }

            $collection = collect($result);

            $pagination = new LengthAwarePaginator(
                $collection->forPage($currentPage ? : $page, $perPage),
                $collection->count(),
                $perPage,
                $currentPage,
                ['path' => url()->current()]
            );
        }
        else { 
            $pagination = collect(new OrderOrder);
        }

        return $pagination; 
    }

    private function GetAllUsers()
    {
        $userprofile = User::with('gender')->paginate(10, ['*'], 'user');
        return $userprofile;
    }
}
