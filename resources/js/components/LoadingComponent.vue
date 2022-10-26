<template>
	<v-overlay
		:value="showOverlay"
		:opacity="0"
		:z-index="10"
	>
		<v-card class="progress-width">
			<v-card-text>
				{{ caption }}
				<v-progress-linear
					color="primary accent-4"
					indeterminate
					rounded
					height="8"
					></v-progress-linear>
			</v-card-text>
		</v-card>
	</v-overlay>
</template>

<script>
	export default {
		props: {
			showOverlay: Boolean,
			caption: String,
		}
	}
</script>

<style scoped>
	.progress-width {
		min-width: 300px;
		font-weight: bold;
	}
</style>