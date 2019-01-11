<template>
    <div
        ref="task"
        class="task-item"
        :class="{
            'task-item--active': active,
            'task-item--done': state === 'done',
            'task-item--cancelled': state === 'cancelled',
        }"
    >
        <div class="task-item__left-column">
            <div class="task-item__column task-item__column--name">
                <div
                    class="task-item__menu-button"
                    @click="onMenuOpened"
                >
                    <span>
                        <i class="fas fa-ellipsis-v" />
                    </span>
                </div>
                <div class="task-item__checkbox">
                    <app-checkbox
                        :checked="state === 'done'"
                        @toggle="onStateCheckboxToggle"
                    />
                </div>
                <div class="task-item__name">{{ name }}</div>
            </div>
        </div>
        <div class="task-item__right-column">
            <div class="task-item__column task-item__column--timer">
                <div class="task-item-timer">
                    <span
                        class="task-item-timer__time"
                        :class="{ 'task-item-timer__time--active': active }"
                    >
                        {{ time }}
                    </span>
                    <div
                        class="task-item-timer__button"
                        :class="{ 'task-item-timer__button--stop': active }"
                        @click="toggleTimer"
                    >
                        <i
                            class="task-item-timer__icon"
                            :class="{
                                'fas fa-stop': active,
                                'task-item-timer__icon--play fas fa-play': !active,
                            }"
                        />
                    </div>
                </div>
            </div>
            <div class="task-item__column task-item__column--transfer">
                <div
                    v-if="transfers.length > 0"
                    class="task-item-for-date"
                >
                    <i class="task-item-for-date__icon fas fa-share" />
                    <span class="task-item-for-date__date">{{ forDateFormatted }}</span>
                </div>
            </div>
            <div class="task-item__column task-item__column--repeatable">
                <div class="task-item-repeatable">
                    <i
                        v-if="repeatType"
                        class="task-item-repeatable__icon fas fa-redo-alt"
                    />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import AppCheckbox from '../AppCheckbox';
    import { mapActions } from 'vuex';
    import moment from 'moment';

    const TIMER_DEFAULT_VALUE = '00:00:00';

    export default {
        name: 'TaskItem',
        components: {
            AppCheckbox,
        },
        props: {
            id: {
                type: Number,
                default: null,
            },
            name: {
                type: String,
                default: '',
            },
            forDate: {
                type: Date,
                default: null,
            },
            start: {
                type: Date,
                default: null,
            },
            end: {
                type: Date,
                default: null,
            },
            state: {
                type: String,
                default: 'in_progress',
                validator: value => [
                    'in_progress',
                    'done',
                    'cancelled',
                ].indexOf(value) > -1,
            },
            transfers: {
                type: Array,
                default: () => [],
            },
            repeatType: {
                type: String,
                default: null,
            },
            repeatValue: {
                type: Array,
                default: null,
            },
            taskIdWithActiveTimer: {
                type: Number,
                default: null,
            },
        },
        data() {
            return {
                active: false,
                timer: {
                    start: null,
                    time: null,
                    worker: null,
                },
            };
        },
        computed: {
            forDateFormatted() {
                return moment(this.forDate).format(this.$t('taskItem.forDateFormat'));
            },
            time() {
                return this.timer.time ? this.timer.time : TIMER_DEFAULT_VALUE;
            },
        },
        watch: {
            taskIdWithActiveTimer(v) {
                // Останавливает таймер, если он уже работает, но был запущен
                // таймер для другой задачи.

                if (this.active && this.id !== v) {
                    this.stopTimer();
                }
            },
            // todo: Останавливать таймер и сохранять время, если задача помечается как done или cancelled.
            // todo: Когда таймер работает, при переходе на другой день таймер не должен перескакивать на другие задачи.
        },
        methods: {
            ...mapActions('task', {
                setState: 'setState',
            }),
            ...mapActions('timing', {
                saveTiming: 'save',
            }),
            onStateCheckboxToggle() {
                this.setState({
                    id: this.id,
                    forDate: this.forDate,
                    state: this.state === 'in_progress' ? 'done' : 'in_progress',
                    transfers: this.transfers,
                });
            },
            onMenuOpened(e) {
                this.$menu.open(e, () => import('../Task/TaskMenu'), {
                    task: this,
                }, {
                    position: {
                        top: -106.5 - 12,
                        left: -175 - 8,
                    },
                });
            },
            toggleTimer() {
                if (this.active) {
                    this.stopTimer();

                    return;
                }

                this.startTimer();
            },
            startTimer() {
                this.timer.start = new Date();
                this.timer.worker = new Worker('workers/timer.js');

                this.timer.worker.postMessage({
                    action: 'start',
                });

                this.active = true;

                this.$emit('on-timer-start', {
                    id: this.id,
                });

                this.timer.worker.onmessage = e => {
                    let date = new Date(null);

                    date.setSeconds(e.data);
                    this.timer.time = date.toISOString().substr(11, 8);
                };
            },
            stopTimer() {
                this.timer.worker.postMessage({
                    action: 'stop',
                });

                this.saveTiming({
                    id: this.id,
                    forDate: this.forDate,
                    start: this.timer.start,
                    end: new Date(),
                });

                this.active = false;

                this.resetTimerData();
            },
            resetTimerData() {
                this.timer = {
                    time: null,
                    worker: null,
                    start: null,
                };
            },
        },
    }
</script>

<style lang="less" scoped>
    @import (reference) '../../less/style';

    .task-item {

        .flex(row, nowrap, space-between, center);
        width: 100%;
        height: 40px;
        position: relative;
        transition: .1s all ease-in-out;

        &:hover {

            .task-item__menu-button {

                .flex(row, nowrap, center, center);

                span {
                    opacity: 1;
                }

            }

        }

        &:hover:not(&--active) {

            .task-item-timer {
                opacity: 1;
            }

        }

        &--active:hover {}

        &--active {

            .task-item-timer {
                opacity: 1;
            }

        }

        &--done {}

        &--cancelled {}

        &--done,
        &--cancelled {

            opacity: .25;

            .task-item-timer,
            .task-item__menu-button {
                visibility: hidden;
            }

            .task-item__name {

                &:before {
                    width: 100%;
                }

            }

        }

        &__left-column {
            .flex(row, nowrap, flex-start, center);
        }

        &__right-column {
            .flex(row, nowrap, flex-end, center);
        }

        &__column {

            .flex(row, nowrap, flex-start, center);
            height: 40px;

            &--name {}

            &--timer {
                margin: 0 12px 0 0;
            }

            &--transfer {}

            &--repeatable {}

        }

        &__menu-button {

            position: absolute;
            top: 8px;
            left: -15px;
            transition: .1s all linear;

            span {

                .flex(row, nowrap, center, center);
                color: @blue_2;
                width: 20px;
                height: 24px;
                opacity: 0;
                cursor: pointer;
                border-radius: 3px;
                transition: .1s all ease-in-out;

                &:hover {
                    color: @blue_1;
                    background-color: @blue_4;
                }

                i {
                    font-size: 12px;
                    color: inherit;
                }

            }

        }

        &__checkbox {
            .flex(row, nowrap, center, center);
            width: 40px;
            height: 40px;
        }

        &__name {

            .font(@primary-font, 16px, 400, @blue_1);
            position: relative;

            &:before {
                content: '';
                top: calc(50% + 1px);
                height: 1px;
                width: 0%;
                left: 0;
                position: absolute;
                background-color: @blue_1;
                transition: .1s all ease-in-out;
            }

        }

    }

    .task-item-for-date {

        margin: 0 24px 0 0;

        &__icon {
            font-size: 12px;
            color: @blue_2;
            margin: 0 6px 0 0;
        }

        &__date {
            .font(@primary-font, 14px, 400, @blue_2);
        }

    }

    .task-item-repeatable {

        .flex(row, nowrap, center, center);
        width: 12px;

        &__icon {
            font-size: 12px;
            color: @blue_2;
        }

    }

    .task-item-timer {

        .flex(row, nowrap, flex-start, center);
        opacity: 0;

        &__button {

            .flex(row, nowrap, center, center);
            width: 32px;
            height: 32px;
            border-radius: 16px;
            color: @blue_1;
            cursor: pointer;
            transition: .1s all ease-in-out;

            &:hover:not(&--stop) {
                background-color: #F6F7F8;
            }

            &--stop {

                color: #fff;
                background-color: #ff5f5f;

                &:hover {
                    background-color: lighten(#ff5f5f, 5%);
                }

            }

        }

        &__icon {

            font-size: 8px;
            color: inherit;

            &--play {
                margin: 0 -3px 0 0;
            }

        }

        &__time {

            .font(@primary-font, 15px, 500, @blue_2);
            margin: 0 12px 0 0;
            opacity: 0;
            transition: .1s all ease-in-out;

            &--active {
                color: @blue_1;
                opacity: 1;
            }

        }

    }
</style>