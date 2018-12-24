let instance = null;

class EventBus {
    constructor() {
        if (!instance) {
            this.events = {};
            instance = this;
        }

        return instance;
    }
    emit(event, message) {
        if (!this.events[event]) {
            return;
        }

        const callbacks = this.events[event];

        for (let i = 0, l = callbacks.length; i < l; i++) {
            const callback = callbacks[i];
            callback.call(this, message);
        }
    }
    on(event, callback) {
        if (!this.events[event]) {
            this.events[event] = [];
        }

        this.events[event].push(callback);
    }
}

const Bus = {
    install(Vue) {
        Vue.prototype.$bus = new EventBus();
    },
};

export default Bus;