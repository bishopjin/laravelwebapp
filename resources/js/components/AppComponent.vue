<template>
	<v-app>
		<router-view></router-view>
		<footer-component/>
	</v-app>
</template>

<script>
	import FooterComponent from './FooterComponent'

	export default {
		components: {
			FooterComponent
		}
	}
</script>