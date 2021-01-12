import Vue from 'vue';
import VueRouter from 'vue-router';
import login from './views/login';
import article from './views/Article';
// import NotFound from './views/notFound';
 
Vue.use(VueRouter);
 
const router = new VueRouter({
    mode: 'history',
    routes:[
        {
            path: '/Article',
            name: 'article',
            component: article
        },
        {
            path: '/login',
            name: 'login',
            component: login
        },
        // {
        //     path: '*',
        //     name: '404',
        //     component: NotFound
        // }
    ]
});
 
export default router;