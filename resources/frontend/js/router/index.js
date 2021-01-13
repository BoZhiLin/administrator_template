import Vue from 'vue';
import VueRouter from 'vue-router';
import Login from '../views/Login';
import Article from '../views/Article';
// import NotFound from './views/notFound';

Vue.use(VueRouter);

const router = new VueRouter({
  mode: 'history',
  routes: [
    {
      path: '/frontend/article',
      name: 'article',
      component: Article
    },
    {
      path: '/frontend/login',
      name: 'login',
      component: Login
    },
    // {
    //     path: '*',
    //     name: '404',
    //     component: NotFound
    // }
  ]
});

export default router;