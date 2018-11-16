import api from '../modules/api';

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
        tasksCount: state => state.items.length,
    },
    actions: {
        taskLoad({ commit }) {
            api.get('/task')
                .then(response => commit('taskLoad', response.data))
            ;
        },
        taskAdd({ commit }, { name }) {
            api.post('/task', {
                name,
            })
                .then(response => commit('taskAdd', response.data))
            ;
        },
        taskRename({ commit }, { id, name }) {
            api.post('/task/' + id + '/name', {
                name,
            })
                .then(() => commit('taskRename', { id, name }))
            ;
        },
        taskRemove({ commit }, { ids }) {
            // todo: Удалять также связанные тайминги (или нет?).

            api.delete('/task', {
                data: {
                    ids,
                },
            })
                .then(() => commit('taskRemove', ids))
            ;
        },
        taskMove({ commit }, { id, position }) {
            api.post('/task/' + id + '/move', {
                position,
            })
                .then(() => commit('taskMove'))
            ;
        },
    },
    mutations: {
        taskLoad(state, tasks) {
            tasks.forEach(task => state.items.push(task));
        },
        taskAdd(state, task) {
            state.items.unshift(task);

            state.items.forEach((task, index) => {
                if (index !== 0) {
                    task.position++;
                }
            });
        },
        taskRename(state, { id, name }) {
            state.items.find(task => {
                if (task.id === id) {
                    return task;
                }
            }).name = name;
        },
        taskRemove(state, ids) {
            ids.forEach(id => {
                state.items.forEach((task, index) => {
                    if (id === task.id) {
                        state.items.splice(index, 1);
                    }
                });
            });

            for (let i = 0; i < state.items.length; i++) {
                state.items[i].position = i;
            }
        },
        taskMove(state) {
            for (let i = 0; i < state.items.length; i++) {
                state.items[i].position = i;
            }
        },
        reset(state) {
            const s = initialState();

            Object.keys(s).forEach(key => {
                state[key] = s[key];
            });
        },
    },
};