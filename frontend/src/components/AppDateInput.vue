<template>
    <div class="date-input">
        <label
            class="date-input__label"
            :class="{ 'date-input__label--required': markLabelAsRequired }"
        >
            <slot />
        </label>
        <input
            :value="formattedValue"
            :placeholder="placeholder"
            type="text"
            class="date-input__input"
            readonly
            @click="openDatepickerMenu"
        />
        <i class="date-input__icon fas fa-calendar" />
    </div>
</template>

<script>
    import AppDatepicker from './AppDatepicker';
    import Event from '../classes/Event';
    import moment from 'moment';

    export default {
        name: 'AppDateInput',
        props: {
            value: {
                type: Date,
                default: null,
            },
            placeholder: {
                type: String,
                default: '',
            },
            markLabelAsRequired: Boolean,
        },
        computed: {
            formattedValue() {
                return this.value ? moment(this.value).format('YYYY-MM-DD') : '';
            },
        },
        mounted() {
            // todo: Исправить - срабатывает 2 раза из-за того что имеем 2 компонента AppDateInput в родителе.
            this.$bus.on('app-date-input:on-date-change', payload => {
                this.$emit('on-change', payload.date);
            });
        },
        methods: {
            openDatepickerMenu(e) {
                let coordinates = e.currentTarget.getBoundingClientRect();

                this.$menu.open(AppDatepicker, {
                    initialDate: this.value,
                    mode: 'single',
                    weekStartIndex: 1,
                    events: [
                        new Event('on-select', [
                            'app-date-input:on-date-change',
                        ]),
                    ],
                }, coordinates.y + 40, coordinates.x);
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