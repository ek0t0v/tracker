<template>
    <div class="dropdown">
        <label
            class="dropdown__label"
            :class="{ 'dropdown__label--required': markLabelAsRequired }"
        >
            {{ label }}
        </label>
        <input
            v-model="value"
            class="dropdown__input"
            readonly
            @click="isDropdownOpened = !isDropdownOpened"
        />
        <transition name="dropdown-transition">
            <div
                v-show="isDropdownOpened"
                class="dropdown__choices"
            >
                <slot />
            </div>
        </transition>
    </div>
</template>

<script>
    export default {
        name: 'AppDropdown',
        props: {
            label: {
                type: String,
                default: 'Label placeholder',
            },
            value: {
                type: String,
                default: '',
            },
            markLabelAsRequired: Boolean,
        },
        data() {
            return {
                isDropdownOpened: false,
            };
        },
    }
</script>

<style lang="less" scoped>
    @import '../less/style';

    .dropdown {

        .noselect;
        .flex(column, nowrap, flex-start, flex-start);
        width: 100%;
        position: relative;

        &__label {

            .font(@primary-font, 13px, 400, @blue_1);
            width: 100%;
            margin: 0 0 8px 0;

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
            cursor: pointer;
            background-color: @blue_5;
        }

        &__choices {
            width: 100%;
            padding: 8px 0;
            border-radius: 3px;
            position: absolute;
            top: calc(17px + 8px + 39px);
            left: 0;
            background-color: #fff;
            box-shadow: 0 0 0 1px rgba(29,44,76,.1), 0 4px 8px rgba(0,0,0,.15);
        }

    }
</style>