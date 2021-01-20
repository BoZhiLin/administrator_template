import Vue from 'vue';
import VueRouter from 'vue-router';
import Login from '../views/Login';
import Dashboard from '../views/dashboard/index.vue'

Vue.use(VueRouter);

const router = new VueRouter({
  mode: 'history',
  routes: [
    {
      path: '/admin/login',
      name: 'admin.login',
      component: Login
    },
    {
      path: '/admin/dashboard',
      name: 'admin.dashboard',
      component: Dashboard
    },
  ]
});

export default router;