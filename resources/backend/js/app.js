import Vue from 'vue'
import router from './router/index.js';
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import VueSwal from 'vue-swal'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

require('./bootstrap');
window.Vue = require('vue').default;

Vue.use(BootstrapVue);
Vue.use(IconsPlugin);
Vue.use(VueSwal);

Vue.component('app', require('./components/App.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router
});
