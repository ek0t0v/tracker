<template>
    <div
        class="dropdown-item"
        :class="{ 'dropdown-item--disabled': disabled }"
        @click="onClick"
    >
        <input
            :value="value.value"
            type="text"
            hidden
        />
        <div class="dropdown-item__icon">
            <i :class="iconCssClass" />
        </div>
        <div class="dropdown-item__name">
            {{ $t(value.translation) }}
        </div>
    </div>
</template>

<script>
    export default {
        name: 'AppDropdownItem',
        props: {
            value: {
                type: Object,
                default: () => {},
            },
            iconCssClass: {
                type: String,
                default: '',
            },
            disabled: Boolean,
        },
        methods: {
            onClick() {
                if (this.disabled) {
                    return;
                }

                this.$parent.$emit('on-change', this.value);
            },
        },
    }
</script>

<style lang="less" scoped>
    @import '../less/style';

    .dropdown-item {

        .flex(row, nowrap, flex-start, center);
        padding: 8px 22px 8px 16px;
        cursor: pointer;
        color: @header_color;
        transition: .1s all ease-in-out;

        &--disabled {
            opacity: .25;
            cursor: default;
            filter: grayscale(100%);
        }

        &:hover:not(.dropdown-item--disabled) {
            background-color: rgba(82,89,117, .05);
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

        &__name {
            .font(@primary-font, 14px, 400, inherit);
        }
    }
</style>