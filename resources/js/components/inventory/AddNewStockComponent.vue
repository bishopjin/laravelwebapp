<template>
	<div class="d-flex justify-center">
		<v-card elevation="15" class="card-width px-3 py-3">
			<div class="d-flex justify-center">
				<AlertComponent 
					:message="alertMsg" 
					:alertType="alertType" 
					:isAlert="isAlert"
					@alertClosed="closeAlert"/>
			</div>
			
			<v-card-title>{{ cardName }}</v-card-title>
			<v-card-text>
				<v-form v-model="validForm" ref="form">
					<!--  -->
					<div class="d-flex align-baseline" v-if="!isAddItem">
						<v-text-field 
							v-model="prodID"
							label="Product ID"
							append-icon="mdi-magnify"
							@click:append="searchItem"
							:rules="ruleProdID"></v-text-field>
					</div>
					<!--  -->
					<v-select
						v-if="isAddItem"
						label="Brand"
						:items="brands"
						item-text="name"
						item-value="id"
						v-model="brand">
					</v-select>
					<v-text-field 
						v-else
						v-model="brand"
						label="Brand"
						:readonly="!isAddItem"></v-text-field>
					<!--  -->
					<v-select
						v-if="isAddItem"
						label="Size"
						:items="sizes"
						item-text="name"
						item-value="id"
						v-model="iSize">
					</v-select>
					<v-text-field 
						v-else
						v-model="iSize"
						label="Size"
						:readonly="!isAddItem"></v-text-field>
					<!--  -->
					<v-select
						v-if="isAddItem"
						label="Color"
						:items="colors"
						item-text="name"
						item-value="id"
						v-model="color">
					</v-select>
					<v-text-field 
						v-else
						v-model="color"
						label="Color"
						:readonly="!isAddItem"></v-text-field>
					<!--  -->
					<v-select
						v-if="isAddItem"
						label="Type"
						:items="types"
						item-text="name"
						item-value="id"
						v-model="iType">
					</v-select>
					<v-text-field 
						v-else
						v-model="iType"
						label="Type"
						:readonly="!isAddItem"></v-text-field>
					<!--  -->
					<v-select
						v-if="isAddItem"
						label="Category"
						:items="categories"
						item-text="name"
						item-value="id"
						v-model="cat">
					</v-select>
					<v-text-field 
						v-else
						v-model="cat"
						label="Category"
						:readonly="!isAddItem"></v-text-field>
					<!--  -->
					<v-text-field 
						v-if="isAddItem"
						v-model="price"
						label="Price"
						:rules="rulePrice"
						type="number"></v-text-field>	
					<v-text-field 
						v-else
						v-model="qty"
						label="Quantity"
						:rules="ruleQty"
						type="number"></v-text-field>	
				</v-form>
			</v-card-text>
			<v-card-actions class="d-flex justify-center">
				<v-btn 
					outlined color="primary"
					block
					:disabled="!isFormValid"
					@click="saveData"
					>Save</v-btn>
			</v-card-actions>
		</v-card>

		<LoadingComponent :showOverlay="isLoading"
			caption="Processing..." />
	</div>
</template>

<script>
	import AlertComponent from '../../components/AlertComponent.vue'
	import LoadingComponent from '../../components/LoadingComponent.vue'

	export default {
		components: {
			AlertComponent,
			LoadingComponent,
		},
		data: () => ({
			prodID: '',
			brand: '',
			iSize: '',
			color: '',
			iType: '',
			cat: '',
			qty: '',
			price: '',
			isAlert: false,
			alertMsg: '',
			alertType: 'warning',
			validForm: false,
			isItemExist: false,
			idEmpty: true,
			ruleProdID: [
				v => !!v || 'Product ID is required',
			],
			ruleQty: [
				v => !!v || 'Quantity is required',
			],
			rulePrice: [
				v => !!v || 'Price is required',
			]
		}),
		props: {
			cardName: String,
			isAddItem: Boolean,
		},
		watch: {
			prodID(val) {
				this.idEmpty = val == '' ? true : false
			}
		},
		created() {
			if (this.isAddItem) {
				this.$store.dispatch('setOverlay', true)
				this.$store.dispatch('newItem') // eslint-disable-next-line
				.then(response => { 
					this.$store.dispatch('setOverlay', false)
				})
			}
		},
		methods: {
			searchItem() {
				this.alertType = 'warning'
				if (this.prodID) {
					this.$store.dispatch('getItemDetails', this.prodID) // eslint-disable-next-line
					.then(response => {
						if (this.$store.getters.getItems != '') {
							let obj = JSON.parse(this.$store.getters.getItems)
							this.prodID = obj.id
							this.brand = obj.brand.brand
							this.iSize = obj.size.size
							this.color = obj.color.color
							this.iType = obj.type.type
							this.cat = obj.category.category
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
			closeAlert() {
				this.$refs.form.reset()
				this.idEmpty = true
				this.isAlert = false
			},
			saveData() {
				let obj = {}, data = []

				if (this.isAddItem) {
					data = {
						inventory_item_brand_id: this.brand,
						inventory_item_size_id: this.iSize,
						inventory_item_color_id: this.color,
						inventory_item_type_id: this.iType,
						inventory_item_category_id: this.cat,
						price: this.price,
					}
				}
				else {
					data = { inventory_item_shoe_id: this.prodID, qty: this.qty }
				}
				obj.url = this.isAddItem ? 'inventory/product' : 'inventory/product/deliver',
				obj.data = data

				this.$store.dispatch('saveOrUpdate', obj)
				.then(response => {
					this.alertType = 'error'
					this.alertMsg = 'Failed'
					
					if (response) {
						this.alertType = 'success'
						this.alertMsg = 'Successful'
					}
					this.isAlert = true
					this.validForm = false
					this.$store.dispatch('setOverlay', false)
				})
			},
			setObjects(strobj, name) {
				let retArray = [], newObj = {}
				if (strobj != '') {
					let obj = JSON.parse(strobj)
					obj.forEach(row => {
						newObj.name = row[name]
						newObj.id = row.id
						retArray.push(newObj)
						newObj = {}
					})
				}

				return retArray
			}
		},
		computed: {
			isLoading() {
				return this.$store.getters.getOverlay
			},
			isFormValid() {
				return this.isAddItem ? this.validForm : this.validForm && this.isItemExist
			},
			brands() {
				return this.setObjects(this.$store.getters.getItemAttr[0], 'brand')
			},
			sizes() {
				return this.setObjects(this.$store.getters.getItemAttr[1], 'size')
			},
			colors() {
				return this.setObjects(this.$store.getters.getItemAttr[2], 'color')
			},
			types() {
				return this.setObjects(this.$store.getters.getItemAttr[3], 'type')
			},
			categories() {
				return this.setObjects(this.$store.getters.getItemAttr[4], 'category')
			},
		}
	}
</script>

<style scoped>
	.card-width {
		width: 500px;
	}
	@media only screen and (max-width: 600px) {
		.card-width {
			width: 100%;
		}
	}
</style>