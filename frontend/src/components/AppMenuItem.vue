<template>
    <div
        class="menu-item"
        :class="{
            'menu-item--disabled': isDisabled,
            'menu-item--danger': type === 'danger'
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
            type: {
                type: String,
                default: 'default',
                validator: value => [
                    'default',
                    'danger',
                ].indexOf(value) !== -1,
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
    @import '../less/style';

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

        &--danger {

            color: #D60000;

            &:hover:not(.menu-item--disabled) {
                background-color: rgba(214,0,0,.05);
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