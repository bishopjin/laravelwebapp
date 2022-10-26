import VueRouter from 'vue-router'
import Vue from 'vue'
import MaintenanceView from './views/MaintenanceView.vue'
import CustomerView from './views/CustomerView.vue'
//import store from '../store/index'

/* components */

Vue.use(VueRouter);

const routes = [
	{
		path: '/menu-ordering/admin', 
		name: 'admin',
		component: MaintenanceView,
		/*meta: {
			reqLogin: true,
		}*/
	},
	{
		path: '/menu-ordering/customer', 
		name: 'customer',
		component: CustomerView,
		/*meta: {
			reqLogin: true,
		}*/
	},
]

const router = new VueRouter({
	mode: 'history',
	scrollBehavior: (to, from, savedPosition) => ({ x: 0, y: 0 }), 
	routes,
});

export default router