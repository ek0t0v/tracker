import api from '../modules/api';
import router from '../modules/router';
import { getPayload } from '../modules/jwt';

function initialState() {
    return {
        authenticated: false,
        data: {
            email: null,
        },
    };
}

export default {
    namespaced: true,
    state: initialState,
    getters: {
        authenticated: state => state.authenticated,
        data: state => state.data,
    },
    actions: {
        userLogin({ commit }, { email, password }) {
            api.post('/token/create', {
                email,
                password,
            })
                .then(response => {
                    localStorage.setItem('accessToken', response.data.token);
                    localStorage.setItem('refreshToken', response.data.refresh_token);

                    // console.log(getPayload(response.data.token).email);
                    commit('userLoginSuccess', {
                        data: {
                            email: getPayload(response.data.token).email,
                        },
                    });

                    router.push('dashboard');
                })
                .catch(() => commit('userLoginFailure'))
            ;
        },
        userLogout({ commit }) {
            localStorage.removeItem('accessToken');
            localStorage.removeItem('refreshToken');

            commit('task/reset', null, { root: true });
            commit('user/reset', null, { root: true });
            commit('reset');

            router.push('home');
        },
    },
    mutations: {
        userLoginSuccess(state, { data }) {
            state.authenticated = true;
            state.data = data;
        },
        userLoginFailure(state) {
            state.authenticated = false;
            state.data.email = null;
        },
        reset(state) {
            const s = initialState();

            Object.keys(s).forEach(key => {
                state[key] = s[key];
            });
        },
    },
}