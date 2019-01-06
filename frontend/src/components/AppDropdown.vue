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
        mounted() {
            window.addEventListener('click', e => {
                if (e.target.closest('.dropdown__input')) {
                    return;
                }

                this.isDropdownOpened = false;
            });
        },
    }
</script>

<style lang="less" scoped>
    @import (reference) '../less/style';

    .dropdown {

        .noselect;
        .flex(column, nowrap, flex-start, flex-start);
        width: 100%;
        position: relative;
        z-index: 1000;

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

    .dropdown-transition-enter-active,
    .dropdown-transition-leave-active {
        transition: all .1s ease-in-out;
    }

    .dropdown-transition-enter-active {
        animation: bounce-in .1s;
    }

    .dropdown-transition-enter, .dropdown-transition-leave-to {
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