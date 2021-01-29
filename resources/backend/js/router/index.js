import Vue from "vue";
import VueRouter from "vue-router";

Vue.use(VueRouter);

const router = new VueRouter({
  mode: 'history',
  routes: [
    {
      path: "/admin/login",
      name: "admin.login",
      component: require("../views/Login.vue").default,
    },
    { 
      path: "/admin/dashboard",
      name: "admin.dashboard",
      component: require("../views/Dashboard.vue").default,
    },
    { 
      path: "/admin/administrators",
      name: "admin.administrators",
      component: require("../views/administrator/Administrators.vue").default,
    },
    { 
      path: "/admin/users",
      name: "admin.users",
      component: require("../views/user/Index.vue").default,
    },
    { 
      path: "/admin/announcements",
      name: "admin.announcements",
      component: require("../views/announcement/Index.vue").default,
    },
    { 
      path: "/admin/banners",
      name: "admin.banners",
      component: require("../views/banner/Index.vue").default,
    },
    { 
      path: "/admin/profile",
      name: "admin.profile",
      component: require("../views/Profile.vue").default,
    },
    { 
      path: '/admin/*',
      meta: { requiresAuth: true },
    }
  ]
});

router.beforeEach((to, from, next) => {
  if (to.matched.some(record => {
    return record.meta.requiresAuth;
  })) {
    if (localStorage.getItem('access_token') === null) {
      next({ path: '/admin/login' });
    } else {
      next({ path: '/admin/dashboard' });
    }
  } else {
    next();
  }
});

export default router