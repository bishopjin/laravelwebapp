<?php 
namespace App\Http\Controllers\Traits;

use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\OrderOrder;
use App\Models\OrderCoupon;
use App\Models\User;

trait MenuOrders
{
	public function GetAllOrder($currentPage, $taxes) : LengthAwarePaginator
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


    public function GetAllUsers() : LengthAwarePaginator
    {
        $userprofile = User::with('gender')->paginate(10, ['*'], 'user');
        return $userprofile;
    }
}

?>