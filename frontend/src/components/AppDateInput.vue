<template>
    <div class="date-input">
        <label
            class="date-input__label"
            :class="{ 'date-input__label--required': markLabelAsRequired }"
        >
            <slot />
        </label>
        <input
            v-click-outside="hideDatepicker"
            :value="value"
            :placeholder="placeholder"
            type="text"
            class="date-input__input"
            @change="onChange"
            @click.self.prevent="showDatepicker"
        />
        <i class="date-input__icon fas fa-calendar" />
        <transition name="fade">
            <app-datepicker
                v-show="isDatepickerOpened"
                :mode="'single'"
                :week-start-index="1"
                class="date-input__datepicker"
                @on-date-changed="onChangedFromDatepicker"
            />
        </transition>
    </div>
</template>

<script>
    import AppDatepicker from './AppDatepicker';
    import moment from 'moment';

    export default {
        name: 'AppDateInput',
        components: {
            AppDatepicker,
        },
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
        },
        data() {
            return {
                isDatepickerOpened: false,
            };
        },
        methods: {
            onChange(e) {
                this.$emit('on-change', e.target.value);
            },
            onChangedFromDatepicker(date) {
                this.$emit('on-change', moment(date).format('YYYY-MM-DD'));
            },
            showDatepicker() {
                this.isDatepickerOpened ? this.hideDatepicker() : this.isDatepickerOpened = true;
            },
            hideDatepicker() {
                this.isDatepickerOpened = false;
            },
        },
    }
</script>

<style lang="less" scoped>
    @import '../less/style';

    .date-input {

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
            padding: 8px 0 8px 26px;

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

        &__icon {
            .flex(row, nowrap, center, center);
            color: @blue_1;
            position: absolute;
            bottom: 0;
            left: 0;
            width: 18px;
            height: 39px;
            font-size: 18px;
        }

        &__datepicker {
            top: calc(39px + 24px + 10px);
            left: -133px;
        }

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