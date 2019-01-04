import Vuex from 'vuex';
import Vue from 'vue';
import task from './task';

Vue.use(Vuex);

function initialState() {
    return {
        date: new Date(),
    };
}

export default new Vuex.Store({
    modules: {
        task,
    },
    state: initialState,
    getters: {
        date: state => state.date,
    },
    actions: {
        setDate({ commit }, payload) {
            commit('setDate', payload.date)
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