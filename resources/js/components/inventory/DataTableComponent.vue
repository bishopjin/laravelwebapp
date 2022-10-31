<template>
	<v-card elevation="15" class="px-4 py-4">
		<v-card-title class="d-flex justify-space-between">
			{{ dtTitle }}
			<v-btn 
				v-if="btnShow"
				text
				color="success"
				@click="emitEvent"
			>{{ btnLabel }}</v-btn>
		</v-card-title>
		<v-card-text>
			<v-text-field v-model="search" label="Search Item" prepend-inner-icon="mdi-magnify" class="searchItem pb-3">
			</v-text-field>

			<v-data-table
				class="elevation-15"
				:headers="dtHeaders"
				:items="inventory"
				:items-per-page="perPage"
				hide-default-footer
				>
				<!-- eslint-disable-next-line -->
				<template v-slot:item.cas="{ item }"> 
					<v-btn 
						text
						:color="item.cas[1] ? 'success' : 'error'"
						@click="setStatus(item.cas[0])">
						{{ rowBtnLbl(item.cas[1]) }}
					</v-btn>
				</template>
			</v-data-table>

			<div class="d-flex justify-end pt-3">
				<v-pagination
					v-model="page"
					:length="linkLength"
					:total-visible="7"
					@input="nextPage(links[page].url)">
				</v-pagination>
			</div>
		</v-card-text>
	</v-card>
</template>

<script>
	export default {
		props: {
			btnShow: Boolean,
			btnLabel: String,
			dtTitle: String,
			dtHeaders: [],
			dtItems: {},
		},
		data: () => ({
			search: '',
			page: 1,
		}),
		watch: {
			linkLength() {
				this.page = 1
			}
		},
		methods: {
			nextPage(nextPage) {
				this.$store.dispatch('nextPage', nextPage)
			},
			toLowerString(data) {
				return String(data).toLowerCase()
			},
			emitEvent() {
				this.$emit('btnClicked')
			},
			rowBtnLbl(cond) {
				return cond ? 'Enable' : 'Disable'
			},
			setStatus(id) {
				this.$store.dispatch('setOverlay', true)
				this.$store.dispatch('userSetAccess', id)
				.then(response => {
					if (response == parseInt(id)) {
						this.$store.dispatch('userEdit') // eslint-disable-next-line
						.then(response => {
							this.$store.dispatch('setOverlay', false)
						})
					}
				})
			}
		},
		computed: {
			inventory() {
				let dtData = []
				if (Object.keys(this.dtItems).length > 0) {
					dtData = this.dtItems.data.filter((row) => {
							let key = [], searchKey = this.search.toLowerCase()
							/* get the key */
							Object.keys(row).forEach((k) => {
								key.push(k)
							})

							if (this.search != '') {
								/* filter data per column, for now max only of 10 colum, NEED to OPTIMIZE */
								if (key.length - 1 >= 0) {
									if (this.toLowerString(row[key[0]]).charAt(0) == searchKey.charAt(0)) {
										return this.toLowerString(row[key[0]]).match(searchKey)
									}
								}

								if (key.length - 2 >= 0) {
									if (this.toLowerString(row[key[1]]).charAt(0) == searchKey.charAt(0)) {
										return this.toLowerString(row[key[1]]).match(searchKey)
									}
								}

								if (key.length - 3 >= 0) {
									if (this.toLowerString(row[key[2]]).charAt(0) == searchKey.charAt(0)) {
										return this.toLowerString(row[key[2]]).match(searchKey)
									}
								}

								if (key.length - 4 >= 0) {
									if (this.toLowerString(row[key[3]]).charAt(0) == searchKey.charAt(0)) {
										return this.toLowerString(row[key[3]]).match(searchKey)
									}
								}

								if (key.length - 5 >= 0) {
									if (this.toLowerString(row[key[4]]).charAt(0) == searchKey.charAt(0)) {
										return this.toLowerString(row[key[4]]).match(searchKey)
									}
								}

								if (key.length - 6 >= 0) {
									if (this.toLowerString(row[key[5]]).charAt(0) == searchKey.charAt(0)) {
										return this.toLowerString(row[key[5]]).match(searchKey)
									}
								}

								if (key.length - 7 >= 0) {
									if (this.toLowerString(row[key[6]]).charAt(0) == searchKey.charAt(0)) {
										return this.toLowerString(row[key[6]]).match(searchKey)
									}
								}

								if (key.length - 8 >= 0) {
									if (this.toLowerString(row[key[7]]).charAt(0) == searchKey.charAt(0)) {
										return this.toLowerString(row[key[7]]).match(searchKey)
									}
								}

								if (key.length - 9 >= 0) {
									if (this.toLowerString(row[key[8]]).charAt(0) == searchKey.charAt(0)) {
										return this.toLowerString(row[key[8]]).match(searchKey)
									}
								}

								if (key.length - 10 >= 0) {
									if (this.toLowerString(row[key[9]]).charAt(0) == searchKey.charAt(0)) {
										return this.toLowerString(row[key[9]]).match(searchKey)
									}
								}
							}
							else {
								return row
							}
						
						})
				}
				return dtData
			},
			links() {
				return this.dtItems.links
			},
			linkLength() {
				return Object.keys(this.dtItems).length > 0 ? this.dtItems.links.length - 2 : 1
			},
			perPage() {
				return this.dtItems ? this.inventory.length : 0
			}
		}
	}
</script>

<style scoped>
	.searchItem {
		width: 25%;
	}

	@media only screen and (max-width: 600px) {
		.searchItem {
			width: 100%;
		}
	}
</style>