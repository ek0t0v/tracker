import VueRouter from 'vue-router';
import Dashboard from '../pages/Dashboard';

const router = new VueRouter({
    routes: [
        {
            path: '/:date?',
            component: Dashboard,
            props: route => ({
                start: route.query.start === undefined ? new Date() : new Date(route.query.start),
            }),
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