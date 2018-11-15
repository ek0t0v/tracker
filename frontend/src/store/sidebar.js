function initialState() {
    return {
        newTimingItemsAdded: false,
    };
}

export default {
    namespaced: true,
    state: initialState,
    getters: {
        newTimingItemsAdded: state => state.newTimingItemsAdded,
    },
    actions: {
        addNewTiming({ commit }) {
            commit('addNewTiming');
        },
        removeNewTimingsNotification({ commit }) {
            commit('removeNewTimingsNotification');
        },
    },
    mutations: {
        addNewTiming(state) {
            state.newTimingItemsAdded = true;
        },
        removeNewTimingsNotification(state) {
            state.newTimingItemsAdded = false;
        },
    },
};