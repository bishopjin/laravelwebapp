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
    public function __construct()
    {
        $this->middleware('auth');
    } 

    /* add new product get interface */
    protected function Index(Request $request)
    {   
        $null_array = array('0' => 'None');
        if (InventoryItemBrand::exists()) {
            $brand = InventoryItemBrand::select('id', 'brand')->get();
        }
        else { $brand = $null_array; }

        if (InventoryItemCategory::exists()) {
            $category = InventoryItemCategory::select('id', 'category')->get();
        }
        else { $category = $null_array; }

        if (InventoryItemType::exists()) {
            $type = InventoryItemType::select('id', 'type')->get();
        }
        else { $type = $null_array; }

        if (InventoryItemColor::exists()) {
            $color = InventoryItemColor::select('id', 'color')->get();
        }
        else { $color = $null_array; }

        if (InventoryItemSize::exists()) {
            $size = InventoryItemSize::select('id', 'size')->get();
        }
        else { $size = $null_array; }

        return view('inventory.product.add')->with(compact('brand', 'category', 'type', 'color', 'size'));
    }

    /* */
    protected function Save(Request $request)
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
            return redirect()->route('inventory.product.create')->withErrors($validator)->withInput();
        }
        else {
            //dd($request->all());
            if (InventoryItemShoe::exists()) {
                $shoeID = InventoryItemShoe::select('itemID')->max('itemID') + 1;
            }
            else { $shoeID = 1000000; }
            /* create new record */
            $create_record = InventoryItemShoe::create(array_merge(array('itemID' => $shoeID), $request->input()));

            if ($create_record->id > 0) { 
            	return redirect()->route('inventory.product.view', ['id' => $create_record->id]); 
            }
            else { 
            	return redirect()->route('inventory.product.create')->withInput(); 
            }
        }
    }

    protected function View(Request $request, $id)
    {
        $item_detail = InventoryItemShoe::join('inventory_item_brands', 'inventory_item_shoes.inventory_item_brand_id', '=', 'inventory_item_brands.id')
            ->join('inventory_item_sizes', 'inventory_item_shoes.inventory_item_size_id', '=', 'inventory_item_sizes.id')
            ->join('inventory_item_colors', 'inventory_item_shoes.inventory_item_color_id', '=', 'inventory_item_colors.id')
            ->join('inventory_item_types', 'inventory_item_shoes.inventory_item_type_id', '=', 'inventory_item_types.id')
            ->join('inventory_item_categories', 'inventory_item_shoes.inventory_item_category_id', '=', 'inventory_item_categories.id')
            ->select('inventory_item_shoes.itemID', 'inventory_item_brands.brand', 'inventory_item_sizes.size', 
                'inventory_item_colors.color', 'inventory_item_types.type', 'inventory_item_categories.category',
                'inventory_item_shoes.price')->where('inventory_item_shoes.id', $id)->get();

    	return view('inventory.product.view')->with(compact('item_detail'));
    }

    protected function OrderAdd()
    {
        $order_summary = InventoryItemShoe::join('inventory_item_brands', 'inventory_item_shoes.inventory_item_brand_id', '=', 'inventory_item_brands.id')
            ->join('inventory_item_orders', 'inventory_item_shoes.id', '=', 'inventory_item_orders.inventory_item_shoe_id')
            ->join('inventory_item_sizes', 'inventory_item_shoes.inventory_item_size_id', '=', 'inventory_item_sizes.id')
            ->join('inventory_item_colors', 'inventory_item_shoes.inventory_item_color_id', '=', 'inventory_item_colors.id')
            ->join('inventory_item_types', 'inventory_item_shoes.inventory_item_type_id', '=', 'inventory_item_types.id')
            ->join('inventory_item_categories', 'inventory_item_shoes.inventory_item_category_id', '=', 'inventory_item_categories.id')
            ->select('inventory_item_shoes.itemID', 'inventory_item_brands.brand', 'inventory_item_sizes.size', 
                'inventory_item_colors.color', 'inventory_item_types.type', 'inventory_item_categories.category',
                'inventory_item_shoes.price', 'inventory_item_shoes.in_stock', 'inventory_item_orders.qty', 
                'inventory_item_orders.order_number')->get();

    	return view('inventory.product.order')->with(compact('order_summary'));
    }

    protected function OrderGet(Request $request)
    {
    	$validator = Validator::make($request->all(), [
	            'item_id' => 'required|numeric',
	    ]);

        if ($validator->fails()) {
            return redirect()->route('order.create')->withErrors($validator)->withInput();
        }
        else {
            $result = InventoryItemShoe::join('inventory_item_brands', 'inventory_item_shoes.inventory_item_brand_id', '=', 'inventory_item_brands.id')
                ->join('inventory_item_sizes', 'inventory_item_shoes.inventory_item_size_id', '=', 'inventory_item_sizes.id')
                ->join('inventory_item_colors', 'inventory_item_shoes.inventory_item_color_id', '=', 'inventory_item_colors.id')
                ->join('inventory_item_types', 'inventory_item_shoes.inventory_item_type_id', '=', 'inventory_item_types.id')
                ->join('inventory_item_categories', 'inventory_item_shoes.inventory_item_category_id', '=', 'inventory_item_categories.id')
                ->select('inventory_item_shoes.itemID', 'inventory_item_brands.brand', 'inventory_item_sizes.size', 
                    'inventory_item_colors.color', 'inventory_item_types.type', 'inventory_item_categories.category',
                    'inventory_item_shoes.price', 'inventory_item_shoes.in_stock', 'inventory_item_shoes.id')
                ->where('inventory_item_shoes.itemID', $request->input('item_id'))->get();
        
	    	return response()->json($result);
        } 
    }

    protected function OrderSave(Request $request)
    {
    	$validator = Validator::make($request->all(), [
	            'shoe_id' => 'required|numeric',
	            'qty' => 'required|numeric',
	    ]);

        if ($validator->fails()) {
            return redirect()->route('order.create')->withErrors($validator)->withInput();
        }
        else {
        	if (InventoryItemOrder::exists()){
	    		$order_number = InventoryItemOrder::select('order_number')->max('order_number') + 1;
	    	}
	    	else { 
                $order_number = 1000000000; 
            }

            $inStock = InventoryItemShoe::find(intval($request->input('shoe_id')))->first();
            
            if (intval($inStock->in_stock) >= intval($request->input('qty'))) {
                $order_created = InventoryItemOrder::create([
                    'order_number' => $order_number,
                    'inventory_item_shoe_id' => $request->input('shoe_id'),
                    'qty' => $request->input('qty'),
                    'order_by_id' => $request->user()->id,
                ]);

                if($order_created->id > 0){
                    $update_stock = InventoryItemShoe::where('id', $request->input('shoe_id'))
                        ->update(['in_stock' => (intval($inStock->in_stock) - intval($request->input('qty')))]); 
                }
            }
            else {
                $update_stock = 0;
            }

	    	return response()->json($update_stock);
        }
    }

    protected function DeliverReceive()
    {
    	return view('inventory.product.receive');
    }

    protected function DeliverSave(Request $request)
    {
    	$validator = Validator::make($request->all(), [
	            'shoe_id' => 'required|numeric',
	            'qty' => 'required|numeric',
	    ]);

        if ($validator->fails()) 
        {
            return redirect()->route('inventory.deliver.create')->withErrors($validator)->withInput();
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
        			->where('itemID', $request->input('shoe_id'))->get();

        		foreach($current_stock as $in_stock)
        		{
        			$stock = $in_stock->in_stock;
        		}

        		$new_stock = intval($request->input('qty')) + intval($stock);

	        	$updated_stock = InventoryItemShoe::where('itemID', $request->input('shoe_id'))
		            ->update(['in_stock' => $new_stock]);

	        	return response()->json($updated_stock);
        	}
        }
    }
}
