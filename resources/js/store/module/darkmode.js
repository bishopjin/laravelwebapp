const darkmode = {
	state: () => ({
		darkMode: false,
	}),
	mutations: {
		setStoredState(state, value) {
			state.darkMode = value
		},
	},
	actions: {
		getStoredState({commit}){
			commit('setStoredState', localStorage.getItem('darkmodestate') === 'true' ? true : false)
		}, 
		changeStoredState({commit}, value) {
			localStorage.setItem('darkmodestate', value)
			commit('setStoredState', value)
		}
	},
	getters: {
		
	}
}

export default darkmode