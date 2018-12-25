import EventBus from '../classes/EventBus';

const Bus = {
    install(Vue) {
        Vue.prototype.$bus = new EventBus();
    },
};

export default Bus;