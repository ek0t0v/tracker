import Vuex from 'vuex';
import Vue from 'vue';
import task from './task';

Vue.use(Vuex);

function initialState() {
    return {};
}

export default new Vuex.Store({
    modules: {
        task,
    },
    state: initialState,
    getters: {},
    actions: {},
    mutations: {},
})