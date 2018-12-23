<template>
    <div class="input">
        <label
            class="input__label"
            :class="{ 'input__label--required': markLabelAsRequired }"
        >
            <slot />
        </label>
        <input
            :value="value"
            :placeholder="placeholder"
            type="text"
            class="input__input"
            @change="onChange"
            @blur="onBlur"
        />
        <div class="input__errors">
            <span
                v-for="(error, index) in validationErrors"
                :key="index"
                class="input__error"
            >
                {{ error }}
            </span>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'AppTextInput',
        props: {
            value: {
                type: String,
                default: '',
            },
            placeholder: {
                type: String,
                default: '',
            },
            markLabelAsRequired: Boolean,
            onBlur: {
                type: Function,
                default: () => { console.log('on blur'); },
            },
            validationErrors: {
                type: Array,
                default: () => [],
            },
        },
        methods: {
            onChange(e) {
                this.$emit('on-change', e.target.value);
            },
        },
    }
</script>

<style lang="less" scoped>
    @import '../less/style';

    .input {

        .flex(column, nowrap, flex-start, flex-start);
        width: 100%;

        &__label {

            .font(@primary-font, 13px, 400, @blue_1);
            width: 100%;
            margin: 0 0 4px 0;

            &--required {

                font-weight: 600;

                &:after {
                    content: ' *';
                }

            }

        }

        &__input {

            .font(@primary-font, 18px, 400, @blue_1);
            width: 100%;
            padding: 8px 0;

            &::placeholder { /* Chrome, Firefox, Opera, Safari 10.1+ */
                color: @blue_2;
                opacity: 1; /* Firefox */
            }

            &:-ms-input-placeholder { /* Internet Explorer 10-11 */
                color: @blue_2;
            }

            &::-ms-input-placeholder { /* Microsoft Edge */
                color: @blue_2;
            }

        }

        &__errors {
            .flex(column, nowrap, flex-start, flex-start);
        }

        &__error {
            .font(@primary-font, 13px, 400, #D60000);
            margin: 0 0 2px 0;

            &:last-child {
                margin: 0;
            }
        }

    }
</style>