<template>
    <div class="date-input">
        <label
            class="date-input__label"
            :class="{ 'date-input__label--required': markLabelAsRequired }"
        >
            <slot />
        </label>
        <div class="date-input__content">
            <input
                :value="formattedValue"
                :placeholder="placeholder"
                type="text"
                class="date-input__input"
                readonly
                @click="openDatepickerMenu"
            />
            <div
                v-if="resettable"
                class="date-input__reset"
                @click="reset"
            >
                <i class="fas fa-times" />
            </div>
            <i class="date-input__icon fas fa-calendar" />
        </div>
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
                validator: v => v instanceof Date,
            },
            placeholder: {
                type: String,
                default: '',
                validator: v => typeof v === 'string',
            },
            markLabelAsRequired: Boolean,
            resettable: {
                type: Boolean,
                default: true,
                validator: v => typeof v === 'boolean',
            },
        },
        computed: {
            formattedValue() {
                return this.value ? moment(this.value).format('YYYY-MM-DD') : '';
            },
        },
        mounted() {
            this.$bus.on(this._uid + ':on-date-change', payload => {
                this.$emit('on-change', payload.date);
            });
        },
        methods: {
            openDatepickerMenu(e) {
                this.$menu.open(e, AppDatepicker, {
                    initialDate: this.value,
                    mode: 'single',
                    weekStartIndex: 1,
                    events: [
                        new Event('on-select', [
                            this._uid + ':on-date-change',
                        ]),
                    ],
                }, {
                    position: {
                        top: 8,
                        left: 0,
                    },
                });
            },
            reset() {
                this.$emit('on-change', null);
            },
        },
    }
</script>

<style lang="less" scoped>
    @import (reference) '../less/style';

    .date-input {

        .flex(column, nowrap, flex-start, flex-start);
        width: 100%;
        position: relative;

        &:hover .date-input__reset {
            opacity: 1;
        }

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

        &__content {
            width: 100%;
            position: relative;
        }

        &__input {

            .font(@primary-font, 18px, 400, @blue_1);
            width: 100%;
            padding: 8px 0 8px 26px;
            box-sizing: border-box;

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

        &__reset {

            .flex(row, nowrap, center, center);
            width: 39px;
            height: 39px;
            position: absolute;
            right: 0;
            top: 0;
            border-radius: 20px;
            transition: .1s all ease-in-out;
            color: #D60000;
            cursor: pointer;
            opacity: 0;

            &:hover {
                background-color: rgba(214, 0, 0, 0.05);
            }

            i {
                color: inherit;
                font-size: 12px;
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

    }
</style>