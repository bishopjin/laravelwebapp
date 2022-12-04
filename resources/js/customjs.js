/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import '@mdi/font/css/materialdesignicons.css'
import 'vuetify/dist/vuetify.min.css';
import Vuetify from 'vuetify'
import store from './store/index'

require('./bootstrap');
window.Vue = require('vue').default;
Vue.use(Vuetify);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
Vue.component('alert-component', require('./components/AlertComponent.vue').default);
Vue.component('add-new-stock-component', require('./components/inventory/AddNewStockComponent.vue').default);
Vue.component('dashboard-datatable-component', require('./components/inventory/DashboardDatatableComponent.vue').default);
Vue.component('order-item-component', require('./components/inventory/OrderItemComponent.vue').default);
Vue.component('order-summary-component', require('./components/inventory/OrderSummaryComponent.vue').default);
Vue.component('student-exam-code-component', require('./components/onlineexam/StudentExamCodeComponent.vue').default);
Vue.component('student-examination-component', require('./components/onlineexam/StudentExaminationComponent.vue').default);
Vue.component('create-examination-form', require('./components/onlineexam/CreateExaminationForm.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#customApp',
    vuetify: new Vuetify(),
    store,
});