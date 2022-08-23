import VueRouter from 'vue-router'
import Vue from 'vue'

/* components */
import MenuAdminComponent from './components/MenuAdminComponent.vue'
import MenuCustomerComponent from './components/MenuCustomerComponent.vue'

Vue.use(VueRouter);

const routes = [
	{
		path: '/menu-ordering/admin',
		component: MenuAdminComponent,
		name: 'admin'
	},
	{
		path: '/menu-ordering/customer',
		component: MenuCustomerComponent,
		name: 'customer'
	},
]

const router = new VueRouter({
	mode: 'history',
	scrollBehavior: (to, from, savedPosition) => ({ x: 0, y: 0 }), 
	routes,
});


export default router