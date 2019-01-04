<template>
    <transition name="modal">
        <div
            v-show="this.$modal.isVisible"
            class="modal-wrapper"
            @click.self.prevent="onClickOutside"
        >
            <transition name="fade">
                <div
                    v-show="this.$modal.isVisible"
                    class="modal"
                >
                    <div class="modal__header">
                        <h1>{{ this.$modal.config.header }}</h1>
                    </div>
                    <div class="modal__content">
                        <current-modal-component />
                    </div>
                    <div
                        v-if="this.$modal.config.closeButton"
                        class="modal__close"
                        @click="onClickCloseButton"
                    >
                        <i class="fas fa-times" />
                    </div>
                </div>
            </transition>
        </div>
    </transition>
</template>

<script>
    import Vue from 'vue';

    Vue.component('current-modal-component', {
        render(h) {
            return h(this.$modal.component, {
                props: this.$modal.props,
            });
        },
    });

    export default {
        name: 'AppModal',
        methods: {
            onClickOutside() {
                if (!this.$modal.config.closeOnClickOutside) {
                    return;
                }

                this.$modal.close();
            },
            onClickCloseButton() {
                if (!this.$modal.config.closeButton) {
                    return;
                }

                this.$modal.close();
            },
        },
    }
</script>

<style lang="less" scoped>
    @import '../less/style';

    .modal-wrapper {
        display: block;
        position: absolute;
        width: 100%;
        height: 100%;
        box-sizing: border-box;
        padding: 48px 0;
        overflow-y: auto;
        opacity: 1;
        background-color: rgba(25,25,25,.7);
    }

    .modal {

        width: fit-content;
        margin: 0 auto;
        border-radius: 3px;
        display: table; // В Firefox не работает fit-content, поэтому table.
        box-shadow: 0 0 0 1px rgba(29,44,76,.1), 0 4px 8px rgba(0,0,0,.15);
        position: relative;

        &__header {

            width: 360px;
            padding: 32px;
            background-color: rgba(82,89,117,.9);

            &--red {
                background-color: rgba(200,70,70,.9);
            }

            h1 {
                .text-clip;
                .font(@primary-font, 20px, 700, #fff);
                padding: unset;
            }

        }

        &__content {
            padding: 32px;
            background-color: #fff;
            border-radius: 0 0 3px 3px;
        }

        &__close {

            .flex(row, nowrap, center, center);
            color: #fff;
            width: 32px;
            height: 32px;
            position: absolute;
            top: -8px;
            right: -32px;
            opacity: .5;
            cursor: pointer;
            transition: .1s opacity ease-in-out;

            &:hover {
                opacity: .75;
            }

            i {
                font-size: 16px;
                color: inherit;
            }

        }

    }

    .modal-enter-active, .modal-leave-active {
        transition: all .1s ease-in-out;
    }

    .modal-enter,
    .modal-leave-active {
        opacity: 0;
    }

    .modal-enter .modal-container,
    .modal-leave-active .modal-container {
        -webkit-transform: scale(1.1);
        transform: scale(1.1);
    }

    .fade-enter-active, .fade-leave-active {
        transition: all .1s ease-in-out;
    }

    .fade-enter-active {
        animation: bounce-in .1s;
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