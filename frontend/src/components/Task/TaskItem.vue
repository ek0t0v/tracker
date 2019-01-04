<template>
    <div
        class="task-item"
        :class="{
            'task-item--active': active,
            'task-item--done': state === 'done',
            'task-item--cancelled': state === 'cancelled',
            'task-item--transferred': isTransferred,
        }"
    >
        <div class="task-item__column">
            <div
                class="task-item__menu-button"
                @click="onMenuOpened"
            >
                <span>
                    <img />
                </span>
            </div>
            <div class="task-item__checkbox">
                <!-- todo: Использовать компонент AppCheckbox. -->
                <div
                    class="checkbox"
                    :class="{
                        'checkbox--done': state === 'done',
                        'checkbox--cancelled': state === 'cancelled',
                        'checkbox--active': active,
                    }"
                    @click="onChecked"
                >
                    <span />
                </div>
            </div>
            <div class="task-item__name">{{ name }}</div>
        </div>
        <div class="task-item__column">
            <!-- todo: Поправить отступы и все такое. -->
            <div
                v-if="transfers.length > 0"
                class="task-item-for-date"
            >
                <i class="task-item-for-date__icon fas fa-share" />
                <span class="task-item-for-date__date">{{ forDateFormatted }}</span>
            </div>
            <div
                v-if="repeatType"
                class="task-item-repeatable"
            >
                <i class="task-item-repeatable__icon fas fa-redo-alt" />
            </div>
        </div>
    </div>
</template>

<script>
    import TaskMenu from '../Task/TaskMenu';
    import { mapActions } from 'vuex';
    import moment from 'moment';

    export default {
        name: 'TaskItem',
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
            isTransferred: Boolean,
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
        },
        data() {
            return {
                active: false,
                done: false,
            };
        },
        computed: {
            forDateFormatted() {
                return moment(this.forDate).format(this.$t('taskItem.forDateFormat'));
            },
        },
        methods: {
            ...mapActions('task', [
                'setState',
            ]),
            onChecked() {
                let state = this.state === 'in_progress' ? 'done' : 'in_progress';

                this.setState({
                    id: this.id,
                    forDate: this.forDate,
                    state: state,
                });
            },
            onMenuOpened(e) {
                this.$menu.open(e, TaskMenu, {
                    task: this,
                }, {
                    position: {
                        top: -106.5 - 12,
                        left: -175 - 8,
                    },
                });
            },
        },
    }
</script>

<style lang="less" scoped>
    @import '../../less/style';

    .task-item {

        .flex(row, nowrap, space-between, center);
        width: 100%;
        height: 40px;
        position: relative;

        &:hover:not(&--active) {

            .task-item__menu-button {

                .flex(row, nowrap, center, center);

                span {
                    opacity: 1;
                }

            }

        }

        &--active:hover {

            .task-item__menu-button {

                .flex(row, nowrap, center, center);
                width: 33px;

                span {
                    opacity: 1;
                }

            }

        }

        &--important {
            background-color: @red_3;
        }

        &--active {

            background-color: @yellow_3;

            .task-item__name {
                color: @yellow_1;
            }

        }

        &--transferred {
            display: none;
        }

        &--done {
            opacity: .25;
            .task-item__name {

                text-decoration: line-through;
            }

        }

        &--cancelled {
            opacity: .25;
            .task-item__name {

                text-decoration: line-through;
            }

        }

        &__column {
            .flex(row, nowrap, flex-start, center);
            height: 40px;
        }

        &__menu-button {

            position: absolute;
            top: 8px;
            left: -19px;
            transition: .1s all linear;

            span {
                .flex(row, nowrap, center, center);
                width: 24px;
                height: 24px;
                opacity: 0;
                cursor: pointer;
                border-radius: 3px;
                transition: .1s all linear;

                &:hover {
                    background-color: @blue_4;
                }

                img {
                    fill: red;
                    width: 8px;
                    height: 13px;
                    background: url(/drag.svg);
                }

                svg {
                    display: block;
                    width: 8px;
                    height: 13px;
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
            line-height: 16px;
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

        &__icon {
            font-size: 12px;
            color: @blue_2;
            margin: 0 8px 0 0;
        }

    }

    .checkbox {

        .flex(row, nowrap, center, center);
        width: 14px;
        height: 14px;
        border-radius: 3px;
        border: 2px solid @blue_2;
        cursor: pointer;

        &--done {

            //border-color: @blue_3;

            span {
                opacity: 1 !important;
                background-color: @blue_2;
            }

        }

        &--cancelled {
            //border-color: @blue_3;
        }

        &--active {

            border-color: @yellow_2;

            span {
                background-color: @yellow_2;
            }

        }

        span {
            width: 10px;
            height: 10px;
            border-radius: 1px;
            display: block;
            opacity: 0;
        }

    }
</style>