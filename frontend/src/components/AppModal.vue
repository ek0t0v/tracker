<template>
    <transition name="modal">
        <div class="modal-mask">
            <div
                class="modal-wrapper"
                @click.self.prevent="$emit('on-close')"
            >
                <div class="modal-container">
                    <div
                        v-if="isHeaderEnabled"
                        class="modal-header"
                    >
                        <slot name="header" />
                    </div>
                    <div class="modal-body">
                        <slot name="body" />
                    </div>
                    <div
                        v-if="isFooterEnabled"
                        class="modal-footer"
                    >
                        <slot name="footer">
                            <button
                                class="modal-footer__button"
                                @click="$emit('on-close')"
                            >
                                Close
                            </button>
                        </slot>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
    export default {
        name: 'AppModal',
        props: {
            isHeaderEnabled: Boolean,
            isFooterEnabled: Boolean,
        },
    }
</script>

<style lang="less" scoped>
    @import '../less/style';

    .modal {}
    .modal-mask {
        position: fixed;
        z-index: 9998;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,.75);
        display: table;
        transition: opacity .1s ease-in-out;
    }
    .modal-wrapper {
        display: table-cell;
        vertical-align: middle;
    }
    .modal-container {
        width: 512px;
        box-sizing: border-box;
        margin: 0 auto;
        background-color: #fff;
        border-radius: 3px;
        box-shadow: 0 0 0 1px rgba(29,44,76,.1), 0 4px 8px rgba(0,0,0,.15);
        transition: all .1s ease-in-out;
    }
    .modal-header {
        margin-top: 0;
        color: #42b983;
    }
    .modal-body {
        .flex(column, nowrap, flex-start, flex-start);
        padding: 32px;
    }
    .modal-footer {

        .flex(row, nowrap, flex-start, flex-start);
        padding: 0 32px 32px 32px;
        //background-color: @blue_5;
        border-radius: 0 0 3px 3px;

        &__button {
            .common-button;
        }

    }

    .modal-header h3 {
        margin-top: 0;
        color: #42b983;
    }

    /*
     * The following styles are auto-applied to elements with
     * transition="modal" when their visibility is toggled
     * by Vue.js.
     *
     * You can easily play with the modal transition by editing
     * these styles.
     */

    .modal-enter {
        opacity: 0;
    }

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