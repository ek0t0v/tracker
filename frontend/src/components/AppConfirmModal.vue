<template>
    <div class="confirm-modal">
        <div class="confirm-modal__content">
            <p class="confirm-modal__text">{{ text }}</p>
        </div>
        <div class="confirm-modal__buttons">
            <button
                class="common-button confirm-modal__confirm-button"
                :class="{ 'confirm-modal__confirm-button--danger': danger }"
                @click="execute"
            >
                {{ confirmButtonText }}
            </button>
            <button
                class="common-button confirm-modal__cancel-button"
                @click="close"
            >
                {{ cancelButtonText }}
            </button>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'AppConfirmModal',
        props: {
            action: {
                type: Function,
                default: null,
            },
            payload: {
                type: Object,
                default: () => {},
            },
            text: {
                type: String,
                default: 'Placeholder',
            },
            confirmButtonText: {
                type: String,
                default: 'OK',
            },
            cancelButtonText: {
                type: String,
                default: 'Cancel',
            },
            danger: Boolean,
        },
        methods: {
            execute() {
                this.action(this.payload);

                this.close();
            },
            close() {
                this.$modal.close();
            },
        },
    }
</script>

<style lang="less" scoped>
    @import (reference) '../less/style';

    .confirm-modal {

        width: 360px;

        &__content {
            margin: 0 0 32px 0;
        }

        &__text {
            .font(@primary-font, 16px, 400, @blue_1);
        }

        &__buttons {
            .flex(row, nowrap, flex-start, flex-start);
        }

        &__confirm-button {

            margin: 0 8px 0 0;

            &:last-child {
                margin: 0;
            }

            &--danger {
                color: #fff;
                background-color: #D60000;
            }

        }

        &__cancel-button {
            color: @blue_1;
            background-color: @blue_4;
        }

    }
</style>