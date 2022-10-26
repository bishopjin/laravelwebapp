<template>
	<v-alert
		v-model="alert"
		:type="alertTyp"
		border="left"
		close-icon="mdi-close"
		dense
		dismissible
		elevation="15"
		transition="scale-transition"
		class="alert-position">
		<span v-html="message"></span>
	</v-alert>
</template>

<script>
	export default {
		props: {
			message: String,
			alertType: String,
			isAlert: Boolean,
		},
		data: () => ({
			alert: false,
		}),
		method: {
			
		},
		beforeUnmount() {
			/* just to make sure that the compunent state is false */
			this.$emit('alertClosed')
		},
		watch: {
			isAlert(newVal) {
				if (newVal) {
					this.alert = newVal
				}
			},
			alert(nval) {
				if (!nval) {
					this.$emit('alertClosed')
				}
			}
		},
		computed: {
			alertTyp() {
				return this.alertType ? this.alertType.toString() :  'error'
			}
		},
	}
</script>

<style scoped>
	.alert-position {
		position: fixed;
		z-index: 10;
		min-width: 300px;
	}
</style>