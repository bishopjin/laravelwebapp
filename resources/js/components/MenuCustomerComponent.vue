<template>
	<v-container fluid>
		<v-row>
			<v-col cols="12">
				{{ msg }}
				<div>
					<button @click="testMethod" class="btn btn-primary">Click</button>
				</div>
				<div>
					<router-link class="text-decoration-none" :to="{name : 'admin'}">Admin</router-link>
				</div>

			</v-col>
		</v-row>
	</v-container>
	
</template>

<script>
	export default {
		data() {
			return {
				msg : 'I am customer motherfucker',
			}
		},
		methods: {
			testMethod() {
				//axios.get("/sanctum/csrf-cookie");

				axios.get('/api/customer/checkCoupon/GO2018')
				.then((response) => {
					alert(JSON.stringify(response))	
				})
				.catch((error) => {
					//alert(error.response.status)
					alert(JSON.stringify(error))
				});
			}
		}
	}
</script>