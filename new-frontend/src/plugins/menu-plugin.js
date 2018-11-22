import CommonContextMenu from '../components/Common/CommonContextMenu';

const MenuPlugin = {
    install(Vue, options) {
        // Vue.prototype.$menuProperty = 'Menu Property';
        // Vue.prototype.$menu = () => {
        //     return this.$menuProperty;
        // };
        Vue.prototype.$contextMenu = {
            open: () => {
                console.log('menu open');
            },
        };
        Vue.directive('menu', {
            inserted: (element, binding) => {
                element.addEventListener('click', e => {
                    console.log(e);
                    console.log(binding.value.actions);

                });

            },
        });

        Vue.component('Menu', CommonContextMenu);
    },
};

export default MenuPlugin;