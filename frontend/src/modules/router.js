import VueRouter from 'vue-router';
import Dashboard from '../pages/Dashboard';

const router = new VueRouter({
    routes: [
        {
            path: '/',
            component: Dashboard,
            name: 'dashboard',
            meta: {
                requiresAuth: false,
            },
        },
        {
            path: '*',
            redirect: '/',
        },
    ],
});

export default router;