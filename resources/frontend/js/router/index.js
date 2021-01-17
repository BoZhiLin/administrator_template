import Vue from 'vue';
import VueRouter from 'vue-router';
import Login from '../views/Login';
import Article from '../views/Article';
import Index from '../views/Index';
// import NotFound from './views/notFound';

Vue.use(VueRouter);

const router = new VueRouter({
  mode: 'history',
  routes: [
    {
      path: '/article',
      name: 'article',
      component: Article
    },
    {
      path: '/login',
      name: 'login',
      component: Login
    },
    {
      path: '/',
      name: 'index',
      component: Index
    },
    // {
    //     path: '*',
    //     name: '404',
    //     component: NotFound
    // }
  ]
});

export default router;