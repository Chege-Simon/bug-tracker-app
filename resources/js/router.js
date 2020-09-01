import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router);

export default new Router({
    routes: [
        {
            name: 'dashboard',
            path: '/dashboard',
            // component: () => import('./components/ProjectDetails')
        },
        // {
        //     path: '/non-existent',
        //     component: () => import('@/components/NonExistentResource')
        // }
    ]
});
