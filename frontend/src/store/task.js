import Vue from 'vue';
import api from '../modules/api';
import moment from 'moment';

function initialState() {
    return {
        items: {},
    };
}

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
            let forDate = moment(payload.start).format('YYYY-MM-DD');

            if (this.state.task.items.hasOwnProperty(forDate)) {
                return;
            }

            return api.get('/tasks?start=' + moment.utc(payload.start).format('YYYY-MM-DD'))
                .then(response => commit('load', {
                    key: forDate,
                    items: response.data.items,
                }))
            ;
        },
        create({ commit, dispatch, rootState }, payload) {
            return api.post('/tasks', {
                name: payload.name,
                start: moment.utc(payload.start).format('YYYY-MM-DD'),
                end: payload.end ? moment.utc(payload.end).format('YYYY-MM-DD') : null,
                repeatType: payload.repeatType ? payload.repeatType.value : null,
                repeatValue: payload.repeatValue,
            })
                .then(() => {
                    commit('reset');
                    dispatch('load', rootState.date);
                })
            ;
        },
        remove({ commit, dispatch, rootState }, payload) {
            api.delete('/tasks/' + payload.id)
                .then(() => {
                    commit('reset');
                    dispatch('load', rootState.date);
                })
            ;
        },
        setState({ commit }, payload) {
            api.put('/tasks/' + payload.id + '/' + moment.utc(payload.forDate).format('YYYY-MM-DD') + '/state', {
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
        setState(state, task) {
            let forDate = moment(task.forDate).format('YYYY-MM-DD');

            state.items[forDate].forEach(item => {
                if (item.id === task.id && item.forDate === task.forDate) {
                    item.state = task.state;
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