import api from '../modules/api';
import moment from 'moment';

function initialState() {
    return {
        items: [],
    };
}

export default {
    namespaced: true,
    state: initialState,
    getters: {
        items: state => state.items,
        count: state => state.items.length,
    },
    actions: {
        load({ commit }, start) {
            return api.get('/tasks?start=' + moment(start).format('YYYY-MM-DD'))
                .then(response => commit('load', response.data.items))
            ;
        },
        create({ commit }, payload) {
            commit('create', payload);
        },
        setState({ commit }, payload) {
            api.put('/tasks/' + payload.id + '/' + moment(payload.forDate).format('YYYY-MM-DD') + '/state', {
                state: payload.state,
            })
                .then(() => commit('setState', payload))
            ;
        }
    },
    mutations: {
        load(state, tasks) {
            state.items = [];

            tasks.forEach(task => {
                task.forDate = new Date(Date.parse(task.forDate));
                state.items.push(task);
            });
        },
        create(state, task) {
            console.log(task);
        },
        setState(state, task) {
            state.items.forEach(item => {
                if (item.id === task.id && item.forDate === task.forDate) {
                    item.state = task.state;
                }
            });
        },
    },
}