import axios from 'axios'
import router from '../../routes'

const user = {
	state: () => ({
		userInfo: {
			username: '',
			permission: [],
			role: [],
			id: 0,
		},
	}),
	mutations: {
		setUser(state, obj) {
			state.userInfo.username = obj.username
			state.userInfo.permission = obj.permission
			state.userInfo.role = obj.role
			state.userInfo.id = obj.id
		},
	},
	actions: {
		getStoredUser({commit, rootState}) {
			if (rootState.token != '') {
				commit('setUser', JSON.parse(localStorage.getItem('userDetail')))
			}
		},
		/* check token */
		// eslint-disable-next-line
		async validateToken({state, dispatch, rootState, rootGetters}) {
			await axios({
				method: 'GET',
				url: rootState.baseurl + 'checkUser',
				headers: rootGetters.getHeaders,
			}) 
			.then((response) => {
				if (response.data != state.userInfo.id) {
					dispatch('login')
				}
			})
			.catch(error => {
				dispatch('checkErrorResponse', error)
				//console.log(error)
			})
		},
		
		async login({commit, dispatch}) {
			dispatch('setOverlay', true)

			await axios({
				method: 'GET',
				url: '/sanctum/csrf-cookie'
			})
			.then(response => {
				dispatch('setOverlay', false)
				commit('setUserLoginState', true)
			})
			.catch(error => {
				console.log(error)
			})
		},
	},
	getters: {
		getUser(state) {
			return state.userInfo
		},
	}
}

export default user