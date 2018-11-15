import Vuex from 'vuex';
import Vue from 'vue';
import task from './task';
import user from './user';
import timing from './timing';
import sidebar from './sidebar';

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        user,
        task,
        timing,
        sidebar,
    },
});