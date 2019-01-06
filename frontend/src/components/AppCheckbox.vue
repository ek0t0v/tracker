<template>
    <div
        class="checkbox"
        @click="onToggle"
    >
        <div
            class="checkbox__check"
            :class="{ 'checkbox__check--checked': checked }"
        >
            <span />
        </div>
        <div
            v-if="this.$slots.default"
            class="checkbox__label"
        >
            <slot />
        </div>
    </div>
</template>

<script>
    export default {
        name: 'AppCheckbox',
        props: {
            checked: Boolean,
        },
        methods: {
            onToggle() {
                this.$emit('toggle');
            },
        },
    }
</script>

<style lang="less" scoped>
    @import '../less/style';

    .checkbox {

        .noselect;
        .flex(row, nowrap, flex-start, center);
        cursor: pointer;

        &__check {

            .flex(row, nowrap, center, center);
            width: 14px;
            height: 14px;
            border-radius: 3px;
            border: 2px solid @blue_2;
            transition: .1s all ease-in-out;

            span {
                width: 10px;
                height: 10px;
                border-radius: 1px;
                display: block;
                opacity: 0;
                background-color: @blue_1;
                transition: .1s opacity ease-in-out;
            }

            &--checked {

                border-color: @blue_1;

                span {
                    opacity: 1;
                }

            }

        }

        &__label {
            .font(@primary-font, 16px, 400, @blue_1);
            margin: 0 0 0 8px;
        }

    }
</style>