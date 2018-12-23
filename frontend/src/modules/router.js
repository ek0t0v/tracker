import VueRouter from 'vue-router';
import Dashboard from '../pages/Dashboard';

const router = new VueRouter({
    routes: [
        { // при переходе надо восстанавливать заголовок страницы (например, перешли на страницу настроек, заголовок изменился)
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