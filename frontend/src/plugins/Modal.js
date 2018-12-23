const Modal = {
    install(Vue) {
        Vue.prototype.$modal = new Vue({
            data() {
                return {
                    isVisible: false,
                    header: '',
                    component: null,
                    props: {},
                };
            },
            methods: {
                open(component, props, header) {
                    document.body.style.overflow = 'hidden';

                    this.isVisible = true;

                    this.header = header;
                    this.component = component;
                    this.props = props;
                },
                close() {
                    // todo: Сделать сброс прокрутки при закрытии окна (scrollTop?)

                    document.body.removeAttribute('style');

                    this.isVisible = false;

                    setTimeout(() => {
                        this.header = '';
                        this.component = null;
                        this.props = {};
                    }, 150);
                },
            },
        });
    },
};

export default Modal;