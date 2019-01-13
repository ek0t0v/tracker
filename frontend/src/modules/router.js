import VueRouter from 'vue-router';
import store from '../store';

const router = new VueRouter({
    routes: [
        {
            path: '/',
            component: () => import('../pages/Home'),
            name: 'home',
            meta: {
                requiresAuth: false,
            },
            beforeEnter: (to, from, next) => {
                // При изменении даты через url новая дата не доходит до
                // AppDatepicker, т.к. он обернут компонентом меню. Можно либо
                // заморочиться с ивентами, либо закрывать все меню/окна при
                // изменении даты через url.

                if (store.state.user.authenticated && from.name === null) {
                    return next('tasks');
                }

                store.state.user.authenticated ? next(false) : next();
            },
        },
        {
            path: '/login',
            component: () => import('../pages/Login'),
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
            component: () => import('../pages/Dashboard'),
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