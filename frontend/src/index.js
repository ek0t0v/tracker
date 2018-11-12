import Vue from 'vue';
import VueRouter from 'vue-router';
import Dashboard from './components/Dashboard';
import Page from './components/Page';
import router from './modules/router';
import store from './store';

Vue.use(VueRouter);

new Vue({
    el: '#app',
    router,
    store,
    render: h => store.state.user.isAuthenticated ? h(Dashboard) : h(Page),
});