import VueRouter from 'vue-router';
import Home from '../components/Page/Home';
import CreateTask from '../components/Page/CreateTask';

const router = new VueRouter({
    routes: [
        {
            path: '/',
            component: Home,
            name: 'home',
            meta: {
                requiresAuth: false,
            },
        },
        {
            path: '/task/create',
            component: CreateTask,
            name: 'create-task',
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