<template>
    <div class="datepicker">
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

    export default {
        name: 'AppDatepicker',
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
            date: {
                type: Date,
                default: () => new Date(),
            },
            leftDateLimit: {
                type: Date,
                default: null,
            },
            rightDateLimit: {
                type: Date,
                default: null,
            },
        },
        data() {
            return {
                localDate: this.date,
            };
        },
        computed: {
            currentMonthName() {
                return moment(this.localDate).format(this.$t('datepicker.monthFormat'));
            },
            currentDay() {
                return moment(this.localDate).day();
            },
            days() {
                let leftBias = moment(this.localDate).startOf('month').weekday() - this.weekStartIndex;

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
                    });
                }

                for (let i = 1; i <= moment(this.localDate).daysInMonth(); i++) {
                    days.push({
                        day: i,
                        month: 0,
                        currentDay: moment(this.localDate).date() === i, // надо определять не только по дню, но и дате в целом
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

                this.$emit('on-date-changed', this.localDate.toDate());
            },
            nextMonth() {
                this.localDate = moment(this.localDate).add(1, 'months');
            },
            previousMonth() {
                this.localDate = moment(this.localDate).subtract(1, 'months');
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
        border-radius: 3px;
        background-color: #fff;
        box-shadow: 0 0 0 1px rgba(29,44,76,.1), 0 4px 8px rgba(0,0,0,.15);
        z-index: 100000000;
        will-change: transform;
        position: absolute;

        &:before,
        &:after {
            content: '';
            display: block;
            position: absolute;
            left: 133px;
            width: 0;
            height: 0;
            border-style: solid;
        }

        &:after {
            top: -20px;
            border-color: transparent transparent #fff transparent;
            border-width: 10px;
        }

        &:before {
            top: -21px;
            border-color: transparent transparent #e6e7eb transparent;
            border-width: 10px;
        }

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
            transition: .1s all ease-in-out;

            &--disabled {
                color: @blue_2;
            }

            &--current {
                color: #fff;
                background-color: @blue_1;
            }

            &:hover:not(.datepicker-days__day--current) {
                background-color: @blue_5;
            }

            span {
                .font(@primary-font, 14px, 500, inherit);
                display: block;
            }

        }

    }
</style>