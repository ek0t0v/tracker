import Vuex from 'vuex';
import Vue from 'vue';
import task from './task';

Vue.use(Vuex);

function initialState() {
    return {};
}

// todo: Может быть стоит разместить здесь выбранную дату (selectedDate)?

export default new Vuex.Store({
    modules: {
        task,
    },
    state: initialState,
    getters: {},
    actions: {},
    mutations: {},
})