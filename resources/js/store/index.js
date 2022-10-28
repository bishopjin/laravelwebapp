import Vuex from 'vuex'
import Vue from 'vue'
import darkmode from './module/darkmode'
import user from './module/user'
import inventory from './module/inventory'
import onlineexam from './module/onlineexam'
import router from '../routes'

Vue.use(Vuex)

export default new Vuex.Store({
	state: {
		baseurl: 'http://127.0.0.1:8000/api/',
		overlayShow: false,
		userIsLoggedIn: false,
	},
	modules: {
		darkmode,
		user,
		inventory,
		onlineexam,
	},
	mutations: {
		setOverlayState(state, value) {
			state.overlayShow = value
		},
		setUserLoginState(state, isLogin) {
			state.userIsLoggedIn = isLogin
		}
	},
	actions: {
		setOverlay({commit}, value) {
			commit('setOverlayState', value)
		},
		checkErrorResponse({dispatch}, error) {
			if (error.response.status == 403) {
				dispatch('login')
			}
			else if (error.response.status == 401) {
				localStorage.removeItem('token')
				localStorage.removeItem('userDetail')
				dispatch('login')
			}
		}
	},
	getters: {
		getUserAuthState(state) {
			return state.userIsLoggedIn
		},
		getOverlay(state) {
			return state.overlayShow
		},
		getHeaders(state){
			/* headers for rest api request */
			let header = {
				'Accepted': 'application/json', 
				'Content-Type': 'application/json', 
			}
			return header
		},
	}
})