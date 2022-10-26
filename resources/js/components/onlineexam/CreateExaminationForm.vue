<template>
	<v-app>
			<v-row 
				v-if="!formCreated"
				justify="center"
			>
				<v-col 
					cols="12"
					md="5"
				>
					<v-card 
						class="px-4"
					>
						<v-card-title>
							Create Examination Form
						</v-card-title>
						<v-card-text>
							<p class="text-subtitle-2 font-weight-bold">
				          <span>
				          	Instruction:
				          </span>
				          <br> Provide the needed information, all field are required.
				          <br> Number of Question - examination total number of question
				          <br> Number of selection per question - the choices for each question.
				      </p>
				      <v-select
				      	label="Subject"
				      	v-model="subject"
				      	:items="subjectLists"
				      	item-value="id"
				      	item-text="subject"
				      	:rules="subjectRule"
				      ></v-select>

				      <v-text-field
				      	label="Number of exam question(s)"
				      	v-model="questionCount"
				      	:rules="questionsRule"
				      ></v-text-field>

				      <v-text-field
				      	label="Number of question selection(s)"
				      	v-model="selectionCount"
				      	:rules="selectionsRule"
				      ></v-text-field>

				      <v-btn
				      	text
				      	color="primary"
				      	:disabled="!disabledBtn"
				      	@click="generateForm"
				      >
				      	Create
				      </v-btn>
						</v-card-text>
					</v-card>
				</v-col>
			</v-row>

			<v-row v-else>
				<v-col col="12">	
					<v-card>
						<v-card-title>
							Examination Form
						</v-card-title>
						<v-card-text>
							<div v-html="formGenerated"></div>
						</v-card-text>
					</v-card>
				</v-col>
			</v-row>
	</v-app>
</template>

<script>
	export default {
		props:{
			subjectList: Array,
			postUrl: String,
			csrfToken: String
		},
		data: () => ({
			htmlOutput: '',
			formCreated: false,
			subject: 0,
			questionCount: 1,
			selectionCount: 1,
			subjectRule: [
				v => !!v || 'Subject is required'
			],
			questionsRule: [
				v => !!v || 'Number of question(s) is required',
				v => !isNaN(parseInt(v)) || 'Number of question(s) must be number',
				v => v > 0 || 'Number of question(s) must be greater than zero',
			],
			selectionsRule: [
				v => !!v || 'Number of selection(s) is required',
				v => !isNaN(parseInt(v)) || 'Number of selection(s) must be number',
				v => v > 0 || 'Number of selection(s) must be greater than zero',
			],
		}),
		methods: {
			generateForm() {
				let htmlForm = `<form method="POST" action="${this.postUrl}" class="px-5">
												<div class="form-group">
												<input type="hidden" name="online_subject_id" value="${this.subject}" />
												<input type="hidden" name="_token" value="${ this.csrfToken }" />`

				htmlForm += `<label>Exam time limit </label>
											<input type="number" class="form-control" name="timer" required/>`

				for (let x = 0; x < this.questionCount; x++) {
					htmlForm += `<label>Question ${x + 1}</label>
											<input type="text" class="form-control" name="question[]" required/>`

					htmlForm += `<label>Correct Answer</label>
											<input type="text" class="form-control" name="answer[]" required/>`

					for (let y = 0; y < this.selectionCount; y++) {
						htmlForm += `<div class="ps-5">
														<label>Selection ${y + 1}</label>
														<input type="text" class="form-control" name="selection[${x}][${y}]" required/>
													</div>`
					}
				}

				htmlForm += `</div>
										<div class="form-group pt-2">
											<input type="submit" value="Save" class="btn btn-outline-primary border-0"/>
										</div>
									</form>`

				this.htmlOutput = htmlForm 
				this.formCreated = true
			},
		},
		computed: {
			formGenerated() {
				return this.htmlOutput
			},
			subjectLists() {
				return this.subjectList
			},
			disabledBtn() {
				return this.subject && this.questionCount > 0 && this.selectionCount > 0
			}
		}
	}
</script>

<style scoped lang="scss">
	::v-deep .v-application--wrap {
    min-height: fit-content;
  }
</style>