<template>
    <div
        class="datepicker"
        @click="onClick"
    >
        <div class="datepicker-navigation">
            <span
                class="datepicker-navigation__button"
                @click="previousMonth"
            >
                <i class="fas fa-angle-left" />
            </span>
            <span class="datepicker-navigation__month">{{ currentMonthName }}</span>
            <span
                class="datepicker-navigation__button"
                @click="nextMonth"
            >
                <i class="fas fa-angle-right" />
            </span>
        </div>
        <div class="datepicker-days">
            <div class="datepicker-days__weekdays">
                <span
                    v-for="(weekday, index) in weekdays"
                    :key="index"
                    class="datepicker-days__weekday"
                >
                    <span>{{ weekday }}</span>
                </span>
            </div>
            <div class="datepicker-days__days">
                <span
                    v-for="(day, index) in days"
                    :key="index"
                    :class="{
                        'datepicker-days__day--disabled': day.month !== 0,
                        'datepicker-days__day--current': day.currentDay,
                        'datepicker-days__day--today': day.today,
                    }"
                    class="datepicker-days__day"
                    @click="selectDate(day)"
                >
                    <span>{{ day.day }}</span>
                </span>
            </div>
        </div>
    </div>
</template>

<script>
    import moment from 'moment';
    import EventMixin from '../mixins/EventMixin';
    import Event from '../classes/Event';

    export default {
        name: 'AppDatepicker',
        mixins: [
            EventMixin,
        ],
        props: {
            mode: {
                type: String,
                default: 'single',
                validator: value => [
                    'single',
                    'range',
                ].indexOf(value) > -1,
            },
            weekStartIndex: {
                type: Number,
                default: 0,
                validator: value => value > -1 && value < 7,
            },
            initialDate: {
                type: Date,
                default: null,
            },
            leftDateLimit: {
                type: Date,
                default: null,
            },
            rightDateLimit: {
                type: Date,
                default: null,
            },
            stopPropagationEnabled: {
                type: Boolean,
                default: true,
            },
            events: {
                type: Array,
                default: () => [],
                validator: array => array.every(element => element instanceof Event),
            },
        },
        data() {
            return {
                localDate: this.initialDate ? this.initialDate : new Date(),
                selectedDateForDays: this.initialDate, // используется для определения текущего дня, когда строим массив дней (computed -> days)
            };
        },
        computed: {
            currentMonthName() {
                let localDateAsMoment = moment(this.localDate);
                let format = localDateAsMoment.isSame(new Date(), 'year')
                    ? this.$t('datepicker.monthFormatForCurrentYear')
                    : this.$t('datepicker.monthFormat');

                return localDateAsMoment.format(format);
            },
            days() {
                let leftBias = moment(this.localDate).startOf('month').isoWeekday() - this.weekStartIndex;

                // Если месяц начинается с первого дня недели (понедельника, например), заполняет всю верхнюю строку днями из прошлого месяца.
                if (leftBias === 0) {
                    leftBias = 7;
                }

                let leftDays = [];
                let days = [];
                let daysInPreviewMonth = moment(this.localDate).subtract(1, 'months').daysInMonth();

                for (let i = 0; i < leftBias; i++) {
                    leftDays.push({
                        day: daysInPreviewMonth - i,
                        month: -1,
                        currentDay: false,
                        today: false,
                    });
                }

                let todayDay = this.getTodayDay();
                let selectedDay = this.getSelectedDay();

                for (let i = 1; i <= moment(this.localDate).daysInMonth(); i++) {
                    days.push({
                        day: i,
                        month: 0,
                        currentDay: selectedDay && selectedDay === i,
                        today: todayDay && todayDay === i,
                    });
                }

                leftDays.reverse();
                days = leftDays.concat(days);

                // Заполняет дни из следующего месяца.
                let rightDays = 42 - days.length;

                for (let i = 1; i <= rightDays; i++) {
                    days.push({
                        day: i,
                        month: 1,
                        currentDay: false,
                        today: false,
                    });
                }

                return days;
            },
            weekdays() {
                let weekdays = moment.weekdays();

                return weekdays.splice(this.weekStartIndex).concat(weekdays).map(weekday => weekday[0]);
            },
        },
        methods: {
            selectDate(day) {
                let date;

                if (day.month === -1) {
                    date = moment(this.localDate).subtract(1, 'months');
                } else if (day.month === 0) {
                    date = moment(this.localDate);
                } else if (day.month === 1) {
                    date = moment(this.localDate).add(1, 'months');
                }

                date = moment(date).date(day.day);

                this.localDate = date;
                this.selectedDateForDays = date;

                this.emitEventsByComponentEvent('on-select', {
                    date: this.localDate.toDate(),
                });
            },
            nextMonth() {
                this.localDate = moment(this.localDate).add(1, 'months');
            },
            previousMonth() {
                this.localDate = moment(this.localDate).subtract(1, 'months');
            },
            getTodayDay() {
                return moment(this.localDate).isSame(new Date(), 'month')
                    ? moment(new Date()).date()
                    : null;
            },
            getSelectedDay() {
                let localDateAsMoment = moment(this.localDate);

                return localDateAsMoment.isSame(this.selectedDateForDays, 'day')
                    ? localDateAsMoment.date()
                    : null;
            },
            onClick(e) {
                if (this.stopPropagationEnabled) {
                    e.stopPropagation();
                }
            },
        },
    }
</script>

<style lang="less" scoped>
    @import '../less/style';

    .datepicker {
        .noselect;
        width: 286px;
        padding: 24px;
        box-sizing: border-box;
        background-color: #fff;
    }

    .datepicker-navigation {

        .flex(row, nowrap, space-between, center);
        margin: 0 0 16px 0;

        &__month {
            .font(@primary-font, 16px, 600, #525975);
            text-transform: capitalize;
        }

        &__button {

            .flex(row, nowrap, center, center);
            width: 34px;
            height: 34px;
            cursor: pointer;
            color: @blue_1;
            border-radius: 3px;
            transition: .1s background-color ease-in-out;

            &:hover {
                background-color: @blue_5;
            }

        }

    }

    .datepicker-days {

        width: 238px;

        &__weekdays {
            .flex(row, nowrap, flex-start, flex-start);
        }

        &__weekday {

            .flex(row, nowrap, center, center);
            width: 34px;
            height: 34px;
            color: @blue_1;
            text-transform: capitalize;

            span {
                .font(@primary-font, 14px, 700, inherit);
                display: block;
            }

        }

        &__days {
            .flex(row, wrap, flex-start, flex-start);
        }

        &__day {

            .flex(row, nowrap, center, center);
            width: 34px;
            height: 34px;
            cursor: pointer;
            color: @blue_1;
            border-radius: 3px;
            transition: .1s all ease-in-out;

            &--disabled {
                color: @blue_2;
            }

            &--current {
                color: #fff !important;
                background-color: @blue_1 !important;
            }

            &--today {
                color: @blue_1;
                background-color: @blue_4;
            }

            &:hover:not(.datepicker-days__day--current):not(.datepicker-days__day--today) {
                background-color: @blue_5;
            }

            span {
                .font(@primary-font, 14px, 500, inherit);
                display: block;
            }

        }

    }
</style>