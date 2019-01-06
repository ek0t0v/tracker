export default {
    namespaced: true,
    state: {},
    getters: {},
    actions: {
        save({ commit }, payload) {
            commit('save', payload);
        },
    },
    mutations: {
        save(state, payload) {
            console.log(payload);
        },
    },
}