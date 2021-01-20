import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

const router = new VueRouter({
  mode: 'history',
  routes: [
    {
      path: '/admin/login',
      name: 'admin.login',
      component: require('../views/Login.vue').default
    },
    {
      path: '/admin/dashboard',
      name: 'admin.dashboard',
      component: require('../views/dashboard/Index.vue').default
    },
  ]
});

export default router;