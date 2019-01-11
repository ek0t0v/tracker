import Vue from 'vue';
import api from '../modules/api';
import moment from 'moment';

function initialState() {
    return {
        items: {},
    };
}

const DATE_FORMAT = 'YYYY-MM-DD';

export default {
    namespaced: true,
    state: initialState,
    getters: {
        items: (state, getters, rootState, rootGetters) => {
            let forDate = moment(rootGetters.date).format('YYYY-MM-DD');

            return state.items.hasOwnProperty(forDate)
                ? state.items[forDate]
                : [];
        },
        count: (state, getters, rootState, rootGetters) => {
            let forDate = moment(rootGetters.date).format('YYYY-MM-DD');

            return state.items.hasOwnProperty(forDate)
                ? state.items[forDate].length
                : 0;
        },
    },
    actions: {
        load({ commit }, payload) {
            let forDate = moment(payload.start).format(DATE_FORMAT);

            if (this.state.task.items.hasOwnProperty(forDate)) {
                return;
            }

            return api.get('/tasks?start=' + forDate)
                .then(response => commit('load', {
                    key: forDate,
                    items: response.data.items,
                }))
            ;
        },
        create({ commit, dispatch, rootState }, payload) {
            payload.start = moment(payload.start).format(DATE_FORMAT);
            payload.end = payload.end ? moment(payload.end).format(DATE_FORMAT) : null;
            payload.repeatType = payload.repeatType ? payload.repeatType.value : null;

            return api.post('/tasks', payload)
                .then(() => {
                    commit('reset');
                    dispatch('load', {
                        start: rootState.date,
                    });
                })
            ;
        },
        remove({ commit, dispatch, rootState }, payload) {
            api.delete('/tasks/' + payload.id)
                .then(() => {
                    commit('reset');
                    dispatch('load', {
                        start: rootState.date,
                    });
                })
            ;
        },
        setState({ commit }, payload) {
            api.put('/tasks/' + payload.id + '/' + moment(payload.forDate).format(DATE_FORMAT) + '/state', {
                state: payload.state,
            })
                .then(() => commit('setState', payload))
            ;
        }
    },
    mutations: {
        load(state, payload) {
            payload.items.forEach(task => {
                task.start = new Date(task.start);
                task.end = task.end ? new Date(task.end) : null;
                task.forDate = new Date(task.forDate);
            });

            Vue.set(state.items, payload.key, payload.items);
        },
        setState(state, payload) {
            let forDate = payload.transfers.length > 0
                ? moment(payload.transfers[payload.transfers.length - 1]).format(DATE_FORMAT)
                : moment(payload.forDate).format(DATE_FORMAT);

            state.items[forDate].forEach(item => {
                if (item.id === payload.id ) {
                    item.state = payload.state;
                }
            });
        },
        reset(state) {
            const s = initialState();

            Object.keys(s).forEach(key => {
                state[key] = s[key]
            });
        },
    },
}