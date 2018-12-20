import Vue from 'vue';
import VueRouter from 'vue-router';
import DashboardPage from './components/Dashboard/DashboardPage';
import router from './modules/router';
import store from './store';
import MenuPlugin from './plugins/menu-plugin';
import ClickOutside from 'v-click-outside';

Vue.use(VueRouter);
Vue.use(ClickOutside);
Vue.use(MenuPlugin);

new Vue({
    el: '#app',
    router,
    store,
    render: h => h(DashboardPage),
});