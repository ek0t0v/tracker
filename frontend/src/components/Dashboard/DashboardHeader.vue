<template>
    <div class="dashboard-header">
        <div class="dashboard-header__column">
            <div class="dashboard-header-logo">
                <i class="far fa-calendar-check" />
            </div>
        </div>
        <div class="dashboard-header__column">
            <div class="dashboard-header-header">
                <slot />
            </div>
        </div>
        <div class="dashboard-header__column">
            <div class="dashboard-header-menu">
                <button
                    class="dashboard-header-menu__button"
                    @click="openCreateTaskModal"
                >
                    <i class="fas fa-plus" />
                </button>
                <button
                    v-click-outside="hideDatepicker"
                    class="dashboard-header-menu__button"
                    @click.self.prevent="toggleDatepicker"
                >
                    <i class="fas fa-calendar" />
                    <transition name="fade">
                        <app-datepicker
                            v-show="datepickerOpened"
                            :mode="'single'"
                            :week-start-index="1"
                            :date="localSelectedDate"
                            class="dashboard-header-datepicker"
                            @on-date-changed="onDateChanged"
                        />
                    </transition>
                </button>
            </div>
            <div
                class="dashboard-header-user"
                style="background-image: url(classic.jpg);"
                @click="openAccountMenu"
            />
        </div>
    </div>
</template>

<script>
    import AppDatepicker from '../AppDatepicker';
    import AccountMenu from '../Dashboard/AccountMenu';
    import CreateTaskForm from '../Task/CreateTaskForm';
    import moment from 'moment';

    export default {
        name: 'DashboardHeader',
        components: {
            AppDatepicker,
        },
        props: {
            selectedDate: {
                type: Date,
                default: new Date(),
            },
        },
        data() {
            return {
                datepickerOpened: false,
                localSelectedDate: this.selectedDate,
                createTaskModalWindowOpened: false,
            };
        },
        watch: {
            selectedDate(date) {
                let to = {
                    name: 'dashboard',
                };

                date = moment(date);

                if (!date.isSame(moment(), 'day')) {
                    to.query = {
                        start: date.format('YYYY-MM-DD'),
                    };
                }

                this.$router.push(to);
            },
        },
        updated() {
            this.localSelectedDate = this.selectedDate;
        },
        methods: {
            toggleDatepicker() {
                this.datepickerOpened ? this.hideDatepicker() : this.datepickerOpened = true;
            },
            hideDatepicker() {
                this.datepickerOpened = false;
            },
            onDateChanged(date) {
                this.selectedDate = date;
            },
            openCreateTaskModal() {
                this.$modal.open(CreateTaskForm, {}, this.$t('modal.header.createTaskForm'));
            },
            openAccountMenu(e) {
                let coordinates = e.currentTarget.getBoundingClientRect();

                this.$menu.open(AccountMenu, {}, coordinates.y + 40, coordinates.x);
            },
        }
    }
</script>

<style lang="less" scoped>
    @import '../../less/style';

    .dashboard-header {

        .flex(row, nowrap, space-between, center);
        width: 1056px;
        height: 128px;
        position: relative;

        &__column {
            .flex(row, nowrap, flex-start, center);
        }

    }

    .dashboard-header-header {
        .font(@primary-font, 24px, 700, @blue_1);
    }

    .dashboard-header-logo {

        .flex(row, nowrap, center, center);
        width: 48px;
        height: 48px;
        border-radius: 24px;

        i {
            font-size: 40px;
            color: @blue_1;
        }

    }

    .dashboard-header-menu {

        .flex(row, nowrap, flex-start, flex-start);
        position: absolute;
        right: calc(48px + 16px);

        &__button {

            .flex(row, nowrap, center, center);
            width: 40px;
            height: 40px;
            margin: 0 4px 0 0;
            background: unset;
            border-radius: 20px;
            position: relative;
            transition: .1s background-color ease-in-out;

            &:last-child {
                margin: 0;
            }

            &:hover {
                background-color: @blue_5;
            }

            i {
                color: @blue_1;
                font-size: 16px;
                pointer-events: none;
            }

        }

    }

    .dashboard-header-datepicker {
        top: calc(40px + 24px);
    }

    .dashboard-header-user {
        width: 48px;
        height: 48px;
        border-radius: 24px;
        background-color: #F5F5F5;
        background-size: cover;
        position: relative;
        cursor: pointer;
    }

    .dashboard-header-account-menu {
        top: calc(48px + 24px);
        right: -66px;
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