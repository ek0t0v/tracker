import * as deepmerge from 'deepmerge'

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
                        config: {
                            arrow: {
                                enabled: true,
                                position: 'top',
                                bias: 0,
                            },
                            position: {
                                top: 0,
                                left: 0,
                            },
                        },
                        top: 0,
                        bottom: 0,
                    },
                    second: {
                        isVisible: false,
                        component: null,
                        props: {},
                        config: {
                            arrow: {
                                enabled: true,
                                position: 'top',
                                bias: 0,
                            },
                            position: {
                                top: 0,
                                left: 0,
                            },
                        },
                        top: 0,
                        bottom: 0,
                    },
                };
            },
            methods: {
                open(component, props, config) {
                    config = deepmerge(this.first.config, config);

                    if (!this.isFirstCellIsSet) {
                        this.first.isVisible = true;
                        this.first.top = config.position.top + 'px';
                        this.first.left = config.position.left + 'px';
                        this.first.component = component;
                        this.first.props = props;

                        this.isFirstCellIsSet = true;

                        return;
                    }

                    this.second.isVisible = true;
                    this.second.top = config.position.top + 'px';
                    this.second.left = config.position.left + 'px';
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