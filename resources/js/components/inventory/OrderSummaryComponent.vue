<template>
	<div>
		<DataTableComponent
			class="mt-3"
			:btnShow="false"
			dtTitle="Order Summary" 
			:dtHeaders="orderTHeader" 
			:dtItems="orderItems"/>

		<LoadingComponent :showOverlay="isLoading"
			:caption="loadingCaption" />
	</div>
</template>

<script>
	import DataTableComponent from './DataTableComponent.vue'
	import LoadingComponent from '../../components/LoadingComponent.vue'

	export default {
		components: {
			DataTableComponent,
			LoadingComponent,
		},
		data: () => ({
			loadingCaption: '',
			orderHeaders: [
				{ text: 'Order Number', value: 'id' },
				{ text: 'Item ID', value: 'itemID' },
				{ text: 'Brand', value: 'brand' },
				{ text: 'Size', value: 'size' },
				{ text: 'Color', value: 'color' },
				{ text: 'Type', value: 'type' },
				{ text: 'Category', value: 'category' },
				{ text: 'Price', value: 'price' },
				{ text: 'Quantity', value: 'qty' },
				{ text: 'Total Cost', value: 'tCost' },
			],
		}),
		created() {
			this.loadingCaption = 'Processing please wait...'
			this.$store.dispatch('setOverlay', true)

			this.$store.dispatch('getOrderInventory') // eslint-disable-next-line
			.then(response => { 
				this.$store.dispatch('setOverlay', false)
			})
		},
		computed: {
			isLoading() {
				return this.$store.getters.getOverlay
			},
			orderTHeader() {
				return this.orderHeaders
			},
			orderItems() {
				let obj = {}, data = [], dataObj = {}, dtData = []
				if (this.$store.getters.getOrderItems.data != '') {
					dtData = JSON.parse(this.$store.getters.getOrderItems.data)
					if (dtData) {
						dtData.forEach((row) => {
							dataObj.id = row.id
							dataObj.itemID = row.inventory_item_shoe_id
							dataObj.brand = row.shoe.brand.brand
							dataObj.size = row.shoe.size.size
							dataObj.color = row.shoe.color.color
							dataObj.type = row.shoe.type.type
							dataObj.category = row.shoe.category.category
							dataObj.price = row.shoe.price
							dataObj.qty = row.qty
							dataObj.tCost = parseInt(row.qty) * parseInt(row.shoe.price)
							/* push the new object into array */
							data.push(dataObj)
							/* reset object */
							dataObj = {}
						})
						obj.data = data
						obj.links = this.$store.getters.getOrderItems.links
					}
				}
				return obj
			}
		},
	}
</script>