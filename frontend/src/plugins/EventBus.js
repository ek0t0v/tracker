import EventBus from '../classes/EventBus';

const Bus = {
    install(Vue) {
        Vue.prototype.$bus = EventBus;
    },
};

export default Bus;