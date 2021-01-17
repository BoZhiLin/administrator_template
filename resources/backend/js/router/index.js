import Vue from 'vue';
import VueRouter from 'vue-router';
import Login from '../views/Login';

Vue.use(VueRouter);

const router = new VueRouter({
  mode: 'history',
  routes: [
    {
      path: '/admin/login',
      name: 'admin.login',
      component: Login
    }
  ]
});

export default router;