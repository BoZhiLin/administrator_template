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
      component: require('../views/dashboard/Index.vue').default,
      children: [
        {
          path: '/admin/administrators',
          component: require('../views/dashboard/Administrators.vue').default,
        },
        {
          path: '/admin/accounts',
          component: require('../views/dashboard/Accounts.vue').default,
        },
        {
          path: '/admin/announcements',
          component: require('../views/dashboard/Announcement.vue').default,
        },
        {
          path: '/admin/banners',
          component: require('../views/dashboard/Banner.vue').default,
        },
        {
          path: '/admin/settings',
          component: require('../views/dashboard/Settings.vue').default,
        },
      ]
    },
  ]
});

export default router;