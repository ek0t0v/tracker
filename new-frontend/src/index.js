import Vue from 'vue';
import VueRouter from 'vue-router';
import DashboardPage from './components/Dashboard/DashboardPage';
// import Page from './components/Page';
import router from './modules/router';
// import store from './store';
import MenuPlugin from './plugins/menu-plugin';

Vue.use(VueRouter);
Vue.use(MenuPlugin);

new Vue({
    el: '#app',
    router,
    // store,
    render: h => h(DashboardPage),
});