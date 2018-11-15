import VueRouter from 'vue-router';
import Home from '../pages/Home';
import Login from '../pages/Login';
import Tasks from '../pages/Tasks';
import History from '../pages/History';
import Settings from '../pages/Settings';
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
                if (store.state.user.isAuthenticated && from.name === null) {
                    return next('tasks');
                }

                store.state.user.isAuthenticated ? next(false) : next();
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
                store.state.user.isAuthenticated ? next(false) : next();
            },
        },
        {
            path: '/tasks',
            component: Tasks,
            name: 'tasks',
            meta: {
                requiresAuth: true,
            },
        },
        {
            path: '/history',
            component: History,
            name: 'history',
            meta: {
                requiresAuth: true,
            },
            beforeEnter: (to, from, next) => {
                store.dispatch('sidebar/removeNewTimingsNotification');
                next();
            },
        },
        {
            path: '/settings',
            component: Settings,
            name: 'settings',
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
        store.state.user.isAuthenticated = true;
    }

    if (!store.state.user.isAuthenticated && to.meta.requiresAuth) {
        return next('/login');
    }

    next();
});

export default router;