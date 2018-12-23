import Vue from 'vue';
import VueRouter from 'vue-router';
import VueI18n from 'vue-i18n'
import App from './components/App';
import router from './modules/router';
import store from './store';
import Menu from './plugins/Menu';
import Modal from './plugins/Modal';
import ClickOutside from 'v-click-outside';
import en from './locales/en';
import ru from './locales/ru';

Vue.use(VueRouter);
Vue.use(VueI18n);
Vue.use(ClickOutside);
Vue.use(Modal);
Vue.use(Menu);

const i18n = new VueI18n({
    locale: 'en',
    fallbackLocale: 'en',
    messages: {
        en,
        ru,
    },
});

new Vue({
    el: '#app',
    router,
    store,
    i18n,
    render: h => h(App),
});