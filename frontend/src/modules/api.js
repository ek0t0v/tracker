import axios from 'axios';
import store from '../store';

// todo: Пофиксить, вроде бы обнаружил вылет при ошибке валидации (422).
// todo: При 401 ошибке надо повторить все запросы, не только первый (кто первый успел, у того запрос повторился).

let retry = false;

export const api = axios.create({
    baseURL: 'http://localhost/api',
    headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
    },
    timeout: 5000,
});

api.interceptors.request.use(config => {
    config.headers.Authorization = 'Bearer ' + localStorage.getItem('accessToken');

    return config;
}, error => Promise.reject(error));

api.interceptors.response.use(null, error => {
    if (error.response.status === 401 && error.response.data.message === 'Bad credentials') {
        return Promise.reject(error);
    }

    if (error.config && error.response.status === 401 && !retry) {
        retry = true;

        return api.post('/token/refresh', {
            refresh_token: localStorage.getItem('refreshToken'),
        })
            .then(response => {
                localStorage.setItem('accessToken', response.data.token);
                localStorage.setItem('refreshToken', response.data.refresh_token);

                error.config.headers.Authorization = 'Bearer ' + response.data.token;

                return api.request(error.config);
            })
            .catch(error => {
                Promise.reject(error);

                store.dispatch('user/userLogout');
            })
        ;
    }

    retry = false;

    return Promise.reject(error);
});

export default api;