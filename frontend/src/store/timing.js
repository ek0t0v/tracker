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
    },
    actions: {
        timingAdd({ commit }, { taskId, start, end }) {
            // перед отправкой на бекенд:
            // преобразовать в UTC
            // преобразовать в unixtime

            commit('timingAdd', { taskId, start, end });
        },
    },
    mutations: {
        timingAdd(state, { taskId, start, end }) {
            state.items.push({
                taskId,
                start,
                end,
            });
        },
    },
}