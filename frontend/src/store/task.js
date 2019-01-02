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
            return api.post('/tasks', {
                name: payload.name,
                start: moment.utc(payload.start).format('YYYY-MM-DD'),
                end: payload.end ? moment.utc(payload.end).format('YYYY-MM-DD') : null,
                repeatType: payload.repeatType ? payload.repeatType.value : null,
                repeatValue: payload.repeatValue,
            })
                .then(response => {
                    let task = response.data;
                    task.forDate = new Date(task.forDate);
                    task.start = new Date(task.start);
                    task.end = task.end ? new Date(task.end) : null;

                    commit('create', task);
                })
            ;
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
                task.forDate = new Date(task.forDate);
                state.items.push(task);
            });
        },
        create(state, task) {
            // todo: Добавлять в нужный день, если task.start === сегодня, то добавляем.
            state.items.unshift(task);
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