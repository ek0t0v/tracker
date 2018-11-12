<template>
    <div
        class="checkbox"
        @click="onCheck"
    >
        <div
            class="checkbox__checkbox"
            :class="{ 'checkbox__checkbox--checked': check === 'CHECKED' }"
        >
            <span
                class="checkbox__check"
                :class="{
                    'checkbox__check--checked': check === 'CHECKED',
                    'checkbox__check--indeterminate': check === 'INDETERMINATE'
                }"
            />
        </div>
        <span class="checkbox__label">
            <slot />
        </span>
    </div>
</template>

<script>
    export const UNCHECKED = 'UNCHECKED';
    export const CHECKED = 'CHECKED';
    export const INDETERMINATE = 'INDETERMINATE';

    export default {
        name: 'Checkbox',
        props: {
            check: {
                type: String,
                required: true,
                validator: value => [
                    UNCHECKED,
                    CHECKED,
                    INDETERMINATE,
                ].indexOf(value) !== -1,
                default: UNCHECKED,
            },
        },
        methods: {
            onCheck() {
                if (this.check === CHECKED || this.check === INDETERMINATE) {
                    this.$emit('on-checked', UNCHECKED);

                    return;
                }

                this.$emit('on-checked', CHECKED);
            },
        },
    };
</script>

<style lang="less" scoped>
    @import '../../less/common';

    .checkbox {

        .noselect;
        .flex(row, nowrap, flex-start, center);
        cursor: pointer;

        &__checkbox {

            .flex(row, nowrap, center, center);
            width: 16px;
            height: 16px;
            border: 1px solid #ccc;
            border-radius: 3px;

            &--checked {
                border-color: #00f;
            }

        }

        &__check {

            width: calc(100% - 4px);
            height: calc(100% - 4px);
            border-radius: 1px;
            display: block;

            &--checked {
                background-color: #00f;
            }

            &--indeterminate {
                background-color: #ccc;
            }

        }

        &__label {
            .font(@primary-font, 15px, 700, #444);
        }

    }
</style>