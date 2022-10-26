<template>
	<div>
		<v-card elevation="15" class="px-5 py-5">
			<div class="d-flex justify-center">
				<AlertComponent 
					:message="alertMsg" 
					:alertType="alertType" 
					:isAlert="isAlert"
					@alertClosed="closeAlert"/>
			</div>				
			<v-card-title>
				Order Item 
			</v-card-title>
			<v-card-text>
				
				<v-text-field 
					v-model="prodID"
					label="Product ID"
					required
					class="search-box"
					append-icon="mdi-magnify"
					@click:append="searchItem"
					:rules="ruleProdID"></v-text-field>
				<!--  -->
				<v-form v-model="validForm" ref="form" :disabled="!isItemExist">
					<v-container>
						<v-row>
							<v-col md="4" cols="12">
								<v-text-field 
									v-model="brand"
									label="Brand"
									readonly></v-text-field>
							</v-col>
							<v-col md="4" cols="12">
								<v-text-field 
									v-model="size"
									label="Size"
									readonly></v-text-field>
							</v-col>
							<v-col md="4" cols="12">
								<v-text-field 
									v-model="color"
									label="Color"
									readonly></v-text-field>
							</v-col>
						</v-row>
						<v-row>
							<v-col md="4" cols="12">
								<v-text-field 
									v-model="type"
									label="Type"
									readonly></v-text-field>
							</v-col>
							<v-col md="4" cols="12">
								<v-text-field 
									v-model="category"
									label="Category"
									readonly></v-text-field>
							</v-col>
							<v-col md="4" cols="12">
								<v-text-field 
									v-model="price"
									label="Price"
									readonly></v-text-field>
							</v-col>
						</v-row>
						<v-row>
							<v-col md="4" cols="12">
								<v-text-field 
									v-model="stock"
									label="In Stock"
									readonly></v-text-field>
							</v-col>
							<v-col md="4" cols="12">
								<v-text-field 
									v-model="qty"
									label="Quantity"
									type="number"
									required
									:rules="ruleQty"></v-text-field>
							</v-col>
							<v-col md="4" cols="12" class="d-flex align-center">
								<v-btn 
									block
									color="primary"
									@click="saveData"
									:disabled="!isValidForm"
									>Save</v-btn>
							</v-col>
						</v-row>
					</v-container>
				</v-form>
			</v-card-text>
		</v-card>
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
	import AlertComponent from '../../components/AlertComponent.vue'
	import DataTableComponent from './DataTableComponent.vue'
	import LoadingComponent from '../../components/LoadingComponent.vue'

	export default {
		components: {
			AlertComponent,
			DataTableComponent,
			LoadingComponent,
		},
		data: () => ({
			loadingCaption: '',
			prodID: '',
			brand: '',
			size: '',
			color: '',
			type: '',
			category: '',
			price: '',
			stock: '',
			qty: '',
			isAlert: false,
			alertMsg: '',
			alertType: 'warning',
			validForm: false,
			isItemExist: false,
			clearForm: false,
			ruleProdID: [
				v => !!v || 'Product ID is required',
			],
			ruleEmpID: [
				v => !!v || 'Employee ID is required',
			],
			ruleQty: [
				v => !!v || 'Quantity is required'
			],
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
			isValidForm() {
				return this.validForm && this.isItemExist
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
		watch: {
			qty(val) {
				let formState = true
				if (parseInt(val) > parseInt(this.stock)) {
					this.isAlert = true
					this.alertMsg = 'Ordered quantity is greater than existing item stock.'
					formState = false
				}
				this.validForm = formState
				this.clearForm = false
			}
		},
		methods: {
			searchItem() {
				this.alertType = 'warning'
				this.clearForm = true
			
				if (this.prodID) {
					this.loadingCaption = 'Processing please wait...'

					this.$store.dispatch('getItemDetails', this.prodID) // eslint-disable-next-line
					.then(response => { 
						if (this.$store.getters.getItems != '') {
							let obj = JSON.parse(this.$store.getters.getItems)
							this.prodID = obj.id
							this.brand = obj.brand.brand
							this.size = obj.size.size
							this.color = obj.color.color
							this.type = obj.type.type
							this.category = obj.category.category
							this.price = obj.price 
							this.stock = obj.in_stock
							this.isItemExist = true
						}
						else {
							this.isAlert = true
							this.alertMsg = 'Item code does not exist'
						}
						this.$store.dispatch('setOverlay', false)
					})
				}
				else {
					this.isAlert = true
					this.alertMsg = 'Product ID is empty'
				}
			},
			saveData() {
				this.loadingCaption = 'Saving please wait...'

				this.$store.dispatch('getStock', [this.prodID, this.qty]) 
				.then(response => {
					this.isAlert = true
					this.clearForm = true

					if (response > 0) {
						this.alertType = 'success'
						this.alertMsg = 'Successful'
					}
					else {
						this.alertType = 'error'
						this.alertMsg = 'Failed' 
						console.log(response.data)
					}
					/* refresh data of datatable */
					this.$store.dispatch('getOrderInventory')
					this.$store.dispatch('setOverlay', false)
				})
			},
			closeAlert() {
				this.isAlert = false
				if (this.clearForm) {
					this.$refs.form.reset()
					this.validForm = false
					this.isItemExist = false
				} 
				this.clearForm = false
			},
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