import VueRouter from 'vue-router'
import Vue from 'vue'

/* components */

Vue.use(VueRouter);

const routes = [
	
]

const router = new VueRouter({
	mode: 'history',
	scrollBehavior: (to, from, savedPosition) => ({ x: 0, y: 0 }), 
	routes,
});


export default router