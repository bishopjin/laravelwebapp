<?php

namespace App\Http\Controllers\InventoryController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\InventoryItemBrand;
use App\Models\InventoryItemCategory;
use App\Models\InventoryItemColor;
use App\Models\InventoryItemSize;
use App\Models\InventoryItemType;
use App\Models\InventoryItemShoe;
use App\Models\InventoryItemOrder;
use App\Models\InventoryItemReceive;

class ProductController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    protected function ProductIndex(Request $request)
    {   
        $brand = InventoryItemBrand::all();
        $category = InventoryItemCategory::all();
        $type = InventoryItemType::all();
        $color = InventoryItemColor::all();
        $size = InventoryItemSize::all();
    
        return view('inventory.product.add')->with(compact('brand', 'category', 'type', 'color', 'size'));
    }

    /* */
    protected function ProductStore(Request $request)
    {
    	$validator = Validator::make($request->all(), [
            'inventory_item_brand_id' => 'required|numeric',
            'inventory_item_size_id' => 'required|numeric',
            'inventory_item_color_id' => 'required|numeric',
            'inventory_item_type_id' => 'required|numeric',
            'inventory_item_category_id' => 'required|numeric',
            'price'=> 'required|numeric',
        ]);
        
        if ($validator->fails()) {
            return redirect()->route('inventory.product.store')->withErrors($validator)->withInput();
        }
        else {
            /* create new record */
            $create_record = InventoryItemShoe::updateOrCreate(
                [
                    'inventory_item_brand_id' => $request->input('inventory_item_brand_id'),
                    'inventory_item_size_id' => $request->input('inventory_item_size_id'),
                    'inventory_item_color_id' => $request->input('inventory_item_color_id'),
                    'inventory_item_type_id' => $request->input('inventory_item_type_id'),
                    'inventory_item_category_id' => $request->input('inventory_item_category_id'),
                ],
                ['price' => $request->input('price')]
            );

            if ($create_record->id > 0) { 
            	return redirect()->route('inventory.product.show', ['id' => $create_record->id]); 
            }
            else { 
            	return redirect()->route('inventory.product.store')->withInput(); 
            }
        }
    }

    protected function ProductShow(Request $request, $id)
    {
        $item_detail = InventoryItemShoe::with(['brand', 'size', 'color', 'type', 'category'])->find($id);
    	return view('inventory.product.view')->with(compact('item_detail'));
    }

    protected function OrderIndex(Request $request)
    {
        if (InventoryItemOrder::exists()) {
            $orders = InventoryItemOrder::with(['shoe.brand', 'shoe.size', 'shoe.color', 'shoe.type', 'shoe.category'])
                ->paginate(10);
            return view('inventory.product.order')->with(compact('orders'));
        }
        else
        {
            return view('inventory.product.order');
        }
    }

    protected function OrderGet(Request $request, $id)
    {
    	$result = InventoryItemShoe::with(['brand', 'size', 'color', 'type', 'category'])->find($id);
        return response()->json($result);
    }

    protected function OrderStore(Request $request)
    {
    	$validator = Validator::make($request->all(), [
	            'shoe_id' => 'required|numeric',
	            'qty' => 'required|numeric',
	    ]);

        if ($validator->fails()) {
            return redirect()->route('inventory.order.store')->withErrors($validator)->withInput();
        }
        else {
        	if (InventoryItemOrder::exists()){
	    		$order_number = InventoryItemOrder::select('order_number')->max('order_number') + 1;
	    	}
	    	else { 
                $order_number = 1000000000; 
            }

            $itemshoe = InventoryItemShoe::find($request->input('shoe_id'));
            
            if (intval($itemshoe->in_stock) >= intval($request->input('qty'))) {
                $order_created = InventoryItemOrder::create([
                    'order_number' => $order_number,
                    'inventory_item_shoe_id' => $request->input('shoe_id'),
                    'qty' => $request->input('qty'),
                    'order_by_id' => $request->user()->id,
                ]);

                if($order_created->id > 0){
                    $newstock = intval($itemshoe->in_stock) - intval($request->input('qty'));
                    $update_stock = $itemshoe->update(['in_stock' => $newstock]); 
                }
            }
            else {
                $update_stock = 0;
            }

	    	return response()->json($update_stock);
        }
    }

    protected function DeliverStore(Request $request)
    {
    	$validator = Validator::make($request->all(), [
	            'shoe_id' => 'required|numeric',
	            'qty' => 'required|numeric',
	    ]);

        if ($validator->fails()) 
        {
            return redirect()->route('inventory.deliver.store')->withErrors($validator)->withInput();
        }
        else
        {
        	$save_deliver = InventoryItemReceive::create([
	    		'inventory_item_shoe_id' => $request->input('shoe_id'),
	    		'qty' => $request->input('qty'),
	    		'user_id' => $request->user()->id,
        	]);

        	if($save_deliver->id > 0)
        	{
        		$stock = 0;

        		$current_stock = InventoryItemShoe::select('in_stock')
        			->find($request->input('shoe_id'));

        		$stock = $current_stock->in_stock;

        		$new_stock = intval($request->input('qty')) + intval($stock);

	        	$updated_stock = InventoryItemShoe::find($request->input('shoe_id'))
		            ->update(['in_stock' => $new_stock]);

	        	return response()->json($updated_stock);
        	}
        }
    }
}
