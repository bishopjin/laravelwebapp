<template>
	<div>
		<v-card
			:light="true"
		>
			<v-card-title>
				{{ examSubject }} &nbsp;
				Examination
			</v-card-title>
			<v-card-text>
				<div>
					<strong>Name: {{ studentName }}</strong>
				</div>
				<div class="pb-2">
					<strong>Examination Code: {{ examCode }}</strong>
				</div>
				<div v-for="(exam, key) in examinations" :key="key">
					<label>
						<strong>
							{{ key + 1 }}. {{ exam.question }}
						</strong>
					</label>
					<v-radio-group 
						dense
						v-model="examAnswer[String(exam.id)]"
						>
						<v-radio
							v-for="(selection, i) in exam.examselection"
							:key="i"
							:label="selection.selection"
							:value="selection.selection"
						></v-radio>
					</v-radio-group>
				</div>
				<v-divider></v-divider>
				<v-btn
					color="primary"
					text
					@click="showPrompt = true"
				>
					Submit
				</v-btn>
			</v-card-text>
		</v-card>

		<v-dialog
      v-model="showPrompt"
      width="300"
      persistent
    >
			<v-card 
					:light="true"
					class="py-5"
				>
					<v-card-subtitle 
						class="text-center"
					>
						Done with the examination?
					</v-card-subtitle>
					<v-card-actions
						class="justify-center"
					>
						<v-btn
							color="primary"
							text
							@click="submitExam"
						>
							Yes
						</v-btn>
						<v-btn
							color="success"
							text
							@click="showPrompt = false"
						>
							No
						</v-btn>
					</v-card-actions>
				</v-card>
		</v-dialog>

		<LoadingComponent :showOverlay="isLoading"
			caption="Saving please wait..." />

		
		<div class="fixed-bottom text-h6 text-md-h5 py-3 text-center bg-light">
			<strong>Examination will end in: {{ examTimer }}</strong>
		</div>
	</div>
</template>

<script>
	import LoadingComponent from '../../components/LoadingComponent.vue'

	export default {
		components: {
			LoadingComponent,
		},
		props: {
			url: String,
		},
		data: () => ({
			examDetails: {},
			examAnswer: [],
			showPrompt: false,
			examTimer: '',
		}),
		mounted() {
			this.getExamination(localStorage.getItem('examcode'))
		},
		methods: {
			getExamination(examCode) {
				if (examCode) {
					this.$store.dispatch('showExamination', this.url + examCode)
					.then(response => {
						if (response.result == 1) {
							this.examDetails = response
							this.countdownTimer(localStorage.getItem('timer'))
						}
					})
				} else {

					location.replace('/online-exam/studentexam')
				}
			},
			submitExam() {
				let examAnswerObj = {}

				this.$store.dispatch('setOverlay', true)

				examAnswerObj.faculty_id = this.examDetails.exams[0].user_id
				examAnswerObj.online_exam_id = this.examDetails.exams[0].id
				examAnswerObj.answer = this.examAnswer ?? null

				this.$store.dispatch('saveExamination', examAnswerObj)
				.then(response => {
					if (response > 0) {
						this.$store.dispatch('setOverlay', false)
						localStorage.clear()
						location.replace('/online-exam/studentexam')
					}
				})
			},
			countdownTimer(timer) {
				let countdown,
					user_id = this.examDetails.exams[0].user_id,
					exam_id = this.examDetails.exams[0].id,
					time_limit = this.examDetails.exams[0].timer

				countdown = parseInt(time_limit) * 60

        if (localStorage.getItem('user_id') && localStorage.getItem('exam_id')) {
        	if (localStorage.getItem('user_id') == String(user_id) && localStorage.getItem('exam_id') == String(exam_id)) {
            if (timer && !isNaN(timer)) {
							countdown = parseInt(timer)
						} 
        	
        	} else {
        		localStorage.setItem('user_id', user_id);
            localStorage.setItem('exam_id', exam_id);
        	}

        } else {
        	localStorage.setItem('user_id', user_id);
          localStorage.setItem('exam_id', exam_id);
        }

        /* arrow function to bind this.examTimer */
				let countdowntimer = setInterval(() => {
            countdown -= 1
            localStorage.setItem('timer', countdown)
            
            this.examTimer = Math.floor(countdown / 60) + ":" + (countdown % 60 ? countdown % 60 : '00')

            if(countdown === 0){
            		clearInterval(countdowntimer)
            		this.submitExam()
            }
        }, 1000)
			}
		},
		computed: {
			isLoading() {
				return this.$store.getters.getOverlay
			},
			studentName() {
				return this.examDetails ? this.examDetails.name : ''
			},
			examinations() {
				return this.examDetails ? this.examDetails.questions : []
			},
			examSubject() {
				return this.examDetails.exams ? this.examDetails.exams[0].onlinesubject.subject : ''
			},
			examCode() {
				return this.examDetails.exams ? this.examDetails.exams[0].exam_code : ''
			},
		}
	}
</script>