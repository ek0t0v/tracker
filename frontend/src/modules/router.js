import VueRouter from 'vue-router';
import Login from '../pages/Login';
import Home from '../pages/Home';
import Dashboard from '../pages/Dashboard';
import store from '../store';

const router = new VueRouter({
    routes: [
        {
            path: '/',
            component: Home,
            name: 'home',
            meta: {
                requiresAuth: false,
            },
            beforeEnter: (to, from, next) => {
                if (store.state.user.authenticated && from.name === null) {
                    return next('tasks');
                }

                store.state.user.authenticated ? next(false) : next();
            },
        },
        {
            path: '/login',
            component: Login,
            name: 'login',
            meta: {
                requiresAuth: false,
            },
            beforeEnter: (to, from, next) => {
                store.state.user.authenticated ? next(false) : next();
            },
        },
        {
            path: '/dashboard:date?',
            component: Dashboard,
            props: route => ({
                start: route.query.start === undefined ? new Date() : new Date(route.query.start),
            }),
            name: 'dashboard',
            meta: {
                requiresAuth: true,
            },
        },
        {
            path: '*',
            redirect: '/',
        },
    ],
});

router.beforeEach((to, from, next) => {
    if (localStorage.getItem('refreshToken')) {
        store.state.user.authenticated = true;
    }

    if (!store.state.user.authenticated && to.meta.requiresAuth) {
        return next('/login');
    }

    next();
});

export default router;