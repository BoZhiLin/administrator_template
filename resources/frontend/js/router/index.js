import Vue from 'vue';
import VueRouter from 'vue-router';
// import NotFound from './views/notFound';

Vue.use(VueRouter);

const router = new VueRouter({
  mode: 'history',
  routes: [
    {
      path: '/article',
      name: 'article',
      component: require('../views/Article.vue').default
    },
    {
      path: '/login',
      name: 'login',
      component: require('../views/Login.vue').default
    },
    {
      path: '/',
      name: 'index',
      component: require('../views/Index.vue').default
    },
    // {
    //     path: '*',
    //     name: '404',
    //     component: NotFound
    // }
  ]
});

export default router;