<?php
namespace App\Http\Controllers\Traits;

use App\Models\InventoryItemBrand;
use App\Models\InventoryItemCategory;
use App\Models\InventoryItemColor;
use App\Models\InventoryItemSize;
use App\Models\InventoryItemType;

trait ProductAttributesTraits
{
	public function getProductAttribute($cacheName, $model)
	{
		if (!cache()->has($cacheName)) {
            cache()->remember($cacheName, $seconds = 86400, function () use($model) {
            	$attrArr = array(
            		'count' => $this->getModelDataCount($model),
            		'attrCollection' => $this->getAttributesData($model),
            	);

                return $attrArr;
            });
        } else {
            if (cache($cacheName)['count'] < $this->getModelDataCount($model)) {
                cache()->forget($cacheName);

                cache()->remember($cacheName, $seconds = 86400, function () use($model) {
	            	$attrArr = array(
	            		'count' => $this->getModelDataCount($model),
	            		'attrCollection' => $this->getAttributesData($model),
	            	);

	                return $attrArr;
	            });
            }
        }

		return cache($cacheName)['attrCollection'];
	}

	/* */
	private function getAttributesData($model)
	{
		switch ($model) {
			case 'brand':
				$collection = InventoryItemBrand::get();
				break;

			case 'type':
				$collection = InventoryItemType::get();
				break;

			case 'color':
				$collection = InventoryItemColor::get();
				break;

			case 'size':
				$collection = InventoryItemSize::get();
				break;

			default:
				$collection = InventoryItemCategory::get();
				break;
		}

		return $collection;
	}

	/* */
	private function getModelDataCount($model)
	{
		switch ($model) {
			case 'brand':
				$count = InventoryItemBrand::count();
				break;

			case 'type':
				$count = InventoryItemType::count();
				break;

			case 'color':
				$count = InventoryItemColor::count();
				break;

			case 'size':
				$count = InventoryItemSize::count();
				break;

			default:
				$count = InventoryItemCategory::count();
				break;
		}

		return $count;
	}
}