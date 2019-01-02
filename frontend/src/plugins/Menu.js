import * as deepmerge from 'deepmerge';

const menuDefaultConfig = {
    position: {
        top: 0,
        left: 0,
    },
};

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
                        config: menuDefaultConfig,
                        width: null,
                        height: null,
                    },
                    second: {
                        isVisible: false,
                        component: null,
                        props: {},
                        config: menuDefaultConfig,
                        width: null,
                        height: null,
                    },
                };
            },
            methods: {
                open(e, component, props, config) {
                    config = deepmerge(menuDefaultConfig, config);

                    let rect = e.currentTarget.getBoundingClientRect();

                    // todo: Ширина меню зависит от локали, учесть это для смещения.
                    config.position = {
                        top: rect.y + rect.height + config.position.top,
                        left: rect.x + config.position.left,
                    };

                    if (!this.isFirstCellIsSet) {
                        this.first.isVisible = true;
                        this.first.component = component;
                        this.first.props = props;
                        this.first.config = config;

                        this.isFirstCellIsSet = true;

                        return;
                    }

                    this.second.isVisible = true;
                    this.second.component = component;
                    this.second.props = props;
                    this.second.config = config;
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