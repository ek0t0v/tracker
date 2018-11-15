<template>
    <div
        class="task-item"
        :class="{ 'task-item--active': timerStarted }"
        :data-id="id"
    >
        <div class="task-item-left-block">
            <div
                v-if="!batchMode"
                class="task-item-left-block__drag-icon"
            >
                <i class="fas fa-grip-vertical" />
            </div>
            <Checkbox
                v-if="batchMode"
                :check="check"
                @on-checked="onChecked"
            />
        </div>
        <input
            v-model="localName"
            class="task-item__name"
            type="text"
            @blur="onNameUpdated"
        />
        <div class="task-item__time">
            <span v-html="timerValue" />
        </div>
        <div class="task-item-right-block">
            <span
                class="task-item-right-block__start-icon"
                @click="timer"
            >
                <i
                    class="fas"
                    :class="{
                        'fa-play': !timerStarted,
                        'fa-stop': timerStarted
                    }"
                />
            </span>
        </div>
        <div class="task-item-right-block">
            <span
                class="task-item-right-block__start-icon"
                @click="onRemoved"
            >
                <i class="far fa-trash-alt" />
            </span>
        </div>
    </div>
</template>

<script>
    // todo: Не создавать тайминг, если быстро кликнули (интервал равен 0).

    import Checkbox from '../Common/Checkbox';
    import { UNCHECKED, CHECKED } from '../Common/Checkbox';
    import { notify, tick } from '../../modules/notify';
    import { mapActions } from 'vuex';

    const DEFAULT_TIMER_VALUE = '00:00:00';

    export default {
        name: 'TaskItem',
        components: {
            Checkbox,
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
            position: {
                type: Number,
                default: 0,
            },
            batchMode: Boolean,
            commonCheck: {
                type: String,
                default: UNCHECKED,
            },
            activeTaskId: {
                type: Number,
                default: null,
            },
        },
        data() {
            return {
                timerValue: DEFAULT_TIMER_VALUE,
                timerStarted: false,
                check: UNCHECKED,
                worker: null,
                localName: this.name,
                timing: {
                    taskId: this.id,
                    start: null,
                    end: null,
                },
            };
        },
        watch: {
            commonCheck() {
                if (this.commonCheck === CHECKED || this.commonCheck === UNCHECKED) {
                    this.check = this.commonCheck;
                }
            },
            activeTaskId() {
                if (this.activeTaskId !== this.id && this.timerStarted) {
                    this.timerStarted = false;
                    this.stopTimer();
                }
            },
        },
        methods: {
            ...mapActions('timing', [
                'timingAdd',
            ]),
            ...mapActions('sidebar', [
                'addNewTiming',
            ]),
            onChecked() {
                this.check = this.check === UNCHECKED ? CHECKED : UNCHECKED;

                this.$emit('on-checked', this.id, this.check);
            },
            onRemoved() {
                if (this.timerStarted) {
                    this.stopTimer(false);
                }

                this.$emit('on-removed', this.id);
            },
            onNameUpdated(e) {
                if (this.name !== e.currentTarget.value) {
                    this.$emit('on-name-updated', this.id, e.currentTarget.value);
                }
            },
            timer() {
                this.timerStarted = !this.timerStarted;

                this.$emit('on-timer-started', this.id, this.timerStarted);

                if (this.timerStarted) {
                    this.timing.start = new Date();

                    this.worker = new Worker('workers/timer.js');
                    this.worker.postMessage({
                        action: 'startTimer',
                    });

                    this.worker.onmessage = e => {
                        tick();

                        let date = new Date(null);
                        date.setSeconds(e.data);

                        this.timerValue = date.toISOString().substr(11, 8);
                        document.title = date.toISOString().substr(11, 8);
                    };

                    return;
                }

                this.stopTimer();
            },
            stopTimer(withTiming = true) {
                this.worker.postMessage({
                    action: 'stopTimer',
                });

                if (withTiming) {
                    this.timing.end = new Date();
                    this.timingAdd(this.timing);
                    this.addNewTiming();
                }

                this.resetTimerData();
            },
            resetTimerData() {
                this.timerValue = DEFAULT_TIMER_VALUE;

                this.timing.start = null;
                this.timing.end = null;
                this.worker = null;

                document.title = '';
            },
        },
    };
</script>

<style lang="less" scoped>
    @import "../../less/common";

    .task-item {

        .noselect;
        .flex(row, nowrap, flex-start, center);
        width: 100%;
        height: 48px;
        background-color: #fff;
        transition: transform 0.25s;

        &--active {
            background-color: #fff4ca !important;
        }

        &:nth-child(even) {
            background-color: #fcfcfc;
        }

        &:hover {

            background-color: #f5f5f5;

            .task-item-left-block__drag-icon {
                opacity: 1;
            }

            .task-item-right-block__start-icon {
                opacity: 1;
            }

        }

        &__name {

            width: 35%;
            margin: 0 48px 0 0;
            padding: 3px 0;
            background-color: rgba(0,0,0,0);
            border-bottom: 2px solid rgba(0,0,0,0);

            &:focus {
                border-bottom: 2px solid rgba(0,0,0,.15);
            }

        }

    }

    .task-item-left-block {

        .flex(row, nowrap, center, center);
        width: 48px;
        height: 48px;


        &__drag-icon {

            .flex(row, nowrap, center, center) !important;
            width: 48px;
            height: 48px;
            display: block;
            opacity: 0;
            cursor: move;
            cursor: -webkit-grabbing;

            i {
                font-size: 12px;
                color: #ccc;
            }

        }

    }

    .task-item-right-block {

        .flex(row, nowrap, center, center);
        width: 48px;
        height: 48px;

        &__start-icon {

            .flex(row, nowrap, center, center) !important;
            width: 32px;
            height: 32px;
            border-radius: 16px;
            display: block;
            opacity: 0;
            cursor: pointer;
            background-color: #3fb010;

            &:hover {
                background-color: darken(#3fb010, 5%);
            }

            i {
                color: #fff;
                font-size: 10px;
                margin: 0 -2px 0 0;
            }

        }

    }
</style>