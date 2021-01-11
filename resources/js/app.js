import Vue from 'vue'
import router from './router.js';
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

require('./bootstrap');
window.Vue = require('vue').default;


// Vue.component(
//     'articles',
//     require('./components/Articles.vue').default);
Vue.component(
    'navbar',
    require('./components/Navbar.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.use(BootstrapVue)
Vue.use(IconsPlugin)
const app = new Vue({
    el: '#app',
    router
});
