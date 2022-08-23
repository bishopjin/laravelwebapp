<template>
	<v-footer padless>
		<v-col class="text-center" cols="12">
			{{ fdate }} — <strong><a :href="furl" target="_blank" class="text-decoration-none">genesedan</a></strong>
		</v-col>
	</v-footer>	
</template>
<script>
	export default {
		data() {
			return {
				fdate: new Date().getFullYear(),
				furl: 'https://genesedan.com/'
			}
		}
	}
</script>