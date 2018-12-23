const Menu = {
    install(Vue) {
        Vue.prototype.$menu = new Vue({
            data() {
                return {
                    isFirstCellIsSet: false,
                    first: {
                        isVisible: false,
                        component: null,
                        props: {},
                        top: 0,
                        bottom: 0,
                    },
                    second: {
                        isVisible: false,
                        component: null,
                        props: {},
                        top: 0,
                        bottom: 0,
                    },
                };
            },
            methods: {
                open(component, props, top, left) {
                    if (!this.isFirstCellIsSet) {
                        this.first.isVisible = true;
                        this.first.top = top + 'px';
                        this.first.left = left + 'px';
                        this.first.component = component;
                        this.first.props = props;

                        this.isFirstCellIsSet = true;

                        return;
                    }

                    this.second.isVisible = true;
                    this.second.top = top + 'px';
                    this.second.left = left + 'px';
                    this.second.component = component;
                    this.second.props = props;
                },
                closeFirstMenu() {
                    this.first.isVisible = false;

                    setTimeout(() => {
                        this.first.component = null;
                        this.first.props = {};
                    }, 150);

                    this.isFirstCellIsSet = false;
                },
                closeSecondMenu() {
                    this.second.isVisible = false;

                    setTimeout(() => {
                        this.second.component = null;
                        this.second.props = {};
                    }, 150);
                },
            },
        });
    },
};

export default Menu;