import axios from 'axios';
import store from '../store';
import httpRetryQueue from './http-retry-queue';

export const api = axios.create({
    baseURL: 'http://localhost/api',
    headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
    },
    timeout: 5000,
});

api.interceptors.request.use(response => {
    response.headers.Authorization = 'Bearer ' + localStorage.getItem('accessToken');

    return response;
}, error => Promise.reject(error));

api.interceptors.response.use(response => response, error => {
    if (error.response.status === 401 && error.response.data.message === 'Bad credentials') {
        return Promise.reject(error);
    }

    if (error.config && error.response.status === 401 && !httpRetryQueue.hasRequestsInQueue()) {
        api.post('/token/refresh', {
            refresh_token: localStorage.getItem('refreshToken'),
        })
            .then(response => {
                localStorage.setItem('accessToken', response.data.token);
                localStorage.setItem('refreshToken', response.data.refresh_token);
                httpRetryQueue.retryAll();
            })
            .catch(error => {
                // todo: Была какая-то ошибка после очистки localStorage - посмотреть/поправить.
                // store.dispatch('user/userLogout');

                return Promise.reject(error);
            })
        ;
    }

    return httpRetryQueue.pushRetryFn({
        reason: '401',
        retryFn: () => {
            error.config.headers.Authorization = 'Bearer ' + localStorage.getItem('accessToken');

            return axios(error.config);
        }
    });
});

export default api;