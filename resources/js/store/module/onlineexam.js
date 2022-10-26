import axios from 'axios'

const onlineexam = {
	state: () => ({
		examTimer: 0,
		userId: 0,
		examCode: '',
	}),
	mutations: {
		setExamTimer(state, timer) {
			if (localStorage.getItem('studentExamDetails')) {
				let details = JSON.parse(localStorage.getItem('studentExamDetails'))

				state.examTimer = details.timer
				state.userId = details.userId
				state.examCode = details.examCode

			} else {
				state.examTimer = timer
			}
		},
	},
	actions: {
		async showExamination({rootState, rootGetters}, url) {
			let respObj = {}

			await axios({
				method: 'GET',
				url: rootState.baseurl + url,
				headers: rootGetters.getHeaders,
			})
			.then(response => {
				respObj = response.data
			})
			.catch(error => {
				respObj.result = 0
				respObj.examTaken = error.message
			})

			return respObj
		},
		async saveExamination({rootState, rootGetters}, examAnswer) {
			let resp = 0

			await axios({
				method: 'POST',
				data: examAnswer,
				url: rootState.baseurl + 'online-exam/studentexam',
				headers: rootGetters.getHeaders,
			})
			.then(response => {
				resp = response.data
			})
			.catch(error => {
				console.log(error)
			})

			return resp
		},
	},
	getters: {
		getExamTimer(state) {
			return state.examTimer
		},
	}
}

export default onlineexam