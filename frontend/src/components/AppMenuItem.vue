<template>
    <div
        class="menu-item"
        :class="{
            'menu-item--disabled': isDisabled,
            'menu-item--red': color === 'red',
            'menu-item--yellow': color === 'yellow',
            'menu-item--green': color === 'green',
        }"
        @click="onClick"
    >
        <div class="menu-item__icon">
            <i :class="iconCssClass" />
        </div>
        <div class="menu-item__label">
            <slot />
        </div>
    </div>
</template>

<script>
    export default {
        name: 'AppMenuItem',
        props: {
            iconCssClass: {
                type: String,
                default: '',
            },
            color: {
                type: String,
                default: 'default',
                validator: v => [
                    'default',
                    'red',
                    'yellow',
                    'green',
                ].indexOf(v) !== -1,
            },
            isDisabled: Boolean,
            closeMenuOnClick: {
                type: Boolean,
                default: true,
            },
        },
        methods: {
            onClick(e) {
                if (!this.closeMenuOnClick) {
                    e.stopPropagation();
                }
            },
        },
    }
</script>

<style lang="less" scoped>
    @import (reference) '../less/style';

    .menu-item {

        .flex(row, nowrap, flex-start, center);
        padding: 8px 22px 8px 16px;
        cursor: pointer;
        color: @header_color;
        transition: .1s all ease-in-out;

        &:hover:not(.menu-item--disabled) {
            background-color: rgba(82,89,117, .05);
        }

        &--disabled {
            opacity: .25;
            cursor: default;
            filter: grayscale(100%);
        }

        &--red {

            color: #D60000;

            &:hover:not(.menu-item--disabled) {
                background-color: rgba(214,0,0,.05);
            }

        }

        &--yellow {

            color: #dfab01;

            &:hover:not(.menu-item--disabled) {
                background-color: rgba(223,171,1,.05);
            }

        }

        &--green {

            color: #0f7b6c;

            &:hover:not(.menu-item--disabled) {
                background-color: rgba(15,123,108,.05);
            }

        }

        &__icon {

            .flex(row, nowrap, center, center);
            width: 18px;
            height: 18px;
            margin: 0 10px 0 0;
            border-radius: 3px;

            i {
                color: @header_color inherit;
                font-size: 15px;
            }

        }

        &__label {
            .font(@primary-font, 14px, 400, inherit);
            white-space: nowrap;
        }

    }
</style>