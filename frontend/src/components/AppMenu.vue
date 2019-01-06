<template>
    <div>
        <transition name="fade">
            <div
                v-show="this.$menu.first.isVisible"
                class="menu"
                :style="{ top: this.$menu.first.config.position.top + 'px', left: this.$menu.first.config.position.left + 'px' }"
            >
                <first-menu-component />
            </div>
        </transition>
        <transition name="fade">
            <div
                v-show="this.$menu.second.isVisible"
                class="menu"
                :style="{ top: this.$menu.second.config.position.top + 'px', left: this.$menu.second.config.position.left + 'px' }"
            >
                <second-menu-component />
            </div>
        </transition>
    </div>
</template>

<script>
    import Vue from 'vue';

    // function isElement(element) {
    //     return element instanceof Element || element instanceof HTMLDocument;
    // }
    //
    // let element = null;

    Vue.component('first-menu-component', {
        updated() {
            this.$menu.first.isVisible
                ? document.addEventListener('click', this.$menu.closeFirstMenu)
                : document.removeEventListener('click', this.$menu.closeFirstMenu);

            // if (this.$menu.first.isVisible && isElement(this.$el)) {
            //     element = this.$el;
            // }
        },
        render(h) {
            return h(this.$menu.first.component, {
                props: this.$menu.first.props,
            });
        },
    });

    Vue.component('second-menu-component', {
        updated() {
            this.$menu.second.isVisible
                ? document.addEventListener('click', this.$menu.closeSecondMenu)
                : document.removeEventListener('click', this.$menu.closeSecondMenu);

            // if (this.$menu.second.isVisible && isElement(this.$el)) {
            //     element = this.$el;
            // }
        },
        render(h) {
            return h(this.$menu.second.component, {
                props: this.$menu.second.props,
            });
        },
    });

    export default {
        name: 'AppMenu',
        // updated() {
        //     this.$menu.opendedBy = element;
        // },
    }
</script>

<style lang="less" scoped>
    @import (reference) '../less/style';

    .menu {
        .noselect;
        position: absolute;
        border-radius: 3px;
        background-color: #fff;
        box-shadow: 0 0 0 1px rgba(29,44,76,.1), 0 4px 8px rgba(0,0,0,.15);
        overflow: hidden;
        z-index: 1000;
    }

    .fade-enter-active, .fade-leave-active {
        transition: all .1s ease-in-out;
    }

    .fade-enter-active {
        animation: bounce-in .1s;
    }

    .bounce-leave-active {
        animation: bounce-in .1s reverse;
    }

    .fade-enter, .fade-leave-to {
        transform-origin: top;
        transform: scale(.9) translateY(-12px) translateY(-12px);
        opacity: 0;
    }

    @keyframes bounce-in {
        90% {
            transform: scale(1.01) translateY(-12px);
        }
        100% {
            transform: scale(1) translateY(-12px);
        }
    }
</style>