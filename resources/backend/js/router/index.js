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
          path: '/admin/users',
          component: require('../views/dashboard/Users.vue').default,
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
          path: '/admin/profiles',
          component: require('../views/dashboard/Profiles.vue').default,
        },
      ]
    },
  ]
});

export default router;