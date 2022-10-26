<template>
	<v-app>
		<v-card outlined>
			<v-card-text>
				<v-form
					ref="form"
					v-model="examCodeForm"
				>
					<v-text-field 
						v-model="examCode"
						label="Examination Code"
						:rules="examCodeRules"
					></v-text-field>
					<div class="text-danger">
						{{ errorMsg }}
					</div>
					<v-btn
						:disabled="btnState"
						color="primary"
						text
						@click="submit"
					>
						<v-progress-circular
							v-if="searching"
				      indeterminate
				      :size="20"
				      color="primary"
				    ></v-progress-circular>
						{{ btnLabel }}
					</v-btn>
				</v-form>
			</v-card-text>
		</v-card>
	</v-app>
</template>

<script>
	export default {
		props: {
			url: String,
			userId: Number,
		},
		created() {
			localStorage.removeItem('examcode')
		},
		data: () => ({
			searching: false,
			examCodeForm: false,
			examCode: '',
			errorMsg: '',
			examCodeRules: [
				v => !!v || 'Examination Code is required',
			],
		}),
		methods: {
			submit() {
				this.searching = true

				this.$store.dispatch('showExamination', this.url + this.examCode)
				.then(response => {
					if (response.result == 1) {
						localStorage.setItem('examcode', this.examCode)
						location.replace('/online-exam/examination/')

					} else {
						this.errorMsg = response.examTaken
					}

					this.searching = false
				})
			}
		},
		computed: {
			btnLabel() {
				return this.searching ? 'Searching...' : 'Submit'
			},
			btnState() {
				let state = false

				state = this.examCodeForm ? (this.searching ? true : false) : true

				return state 
			},
		},
	}
</script>

<style scoped lang="scss">
	::v-deep .v-application--wrap {
    min-height: fit-content;
  }
</style>