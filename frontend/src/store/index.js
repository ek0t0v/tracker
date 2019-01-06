import Vuex from 'vuex';
import Vue from 'vue';
import user from './user';
import task from './task';
import timing from './timing';

Vue.use(Vuex);

function initialState() {
    return {
        date: new Date(),
    };
}

export default new Vuex.Store({
    modules: {
        user,
        task,
        timing,
    },
    state: initialState,
    getters: {
        date: state => state.date,
    },
    actions: {
        setDate({ commit }, payload) {
            commit('setDate', payload.date);
        },
    },
    mutations: {
        setDate(state, date) {
            state.date = date;
        },
        reset(state) {
            const s = initialState();

            Object.keys(s).forEach(key => {
                state[key] = s[key]
            });
        },
    },
})