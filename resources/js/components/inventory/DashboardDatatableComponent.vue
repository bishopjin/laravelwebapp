<template>
	<div>
		<DataTableComponent
			:btnShow="false"
			dtTitle="Inventory" 
			:dtHeaders="orderTHeader" 
			:dtItems="items"/>

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
			loadingCaption: 'Processing please wait...',
			orderHeaders: [
				{ text: 'Product ID', value: 'id' },
				{ text: 'Brand', value: 'brand' },
				{ text: 'Size', value: 'size' },
				{ text: 'Color', value: 'color' },
				{ text: 'Type', value: 'type' },
				{ text: 'Category', value: 'category' },
				{ text: 'Price', value: 'price' },
				{ text: 'In Stock', value: 'in_stock' },
			],
		}),
		created() {
			this.$store.dispatch('setOverlay', true)

			this.$store.dispatch('getItemInventory') // eslint-disable-next-line
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
			items() {
				let obj = {}, data = [], dataObj = {}, dtData = []
				if (this.$store.getters.getInventoryItems.data != '') {
					dtData = JSON.parse(this.$store.getters.getInventoryItems.data)
					dtData.forEach((row) => {
						dataObj.id = row.id
						dataObj.brand = row.brand.brand
						dataObj.size = row.size.size
						dataObj.color = row.color.color
						dataObj.type = row.type.type
						dataObj.category = row.category.category
						dataObj.price = row.price
						dataObj.in_stock = row.in_stock
						/* push the new object into array */
						data.push(dataObj)
						/* reset object */
						dataObj = {}
					})
					obj.data = data
					obj.links = this.$store.getters.getInventoryItems.links
				}
				return obj
			}
		},
	}
</script>

<style scoped>
	.search-box {
		width: 40%;
	}
	@media only screen and (max-width: 600px) {
		.search-box {
			width: 100%;
		}
	}
</style>