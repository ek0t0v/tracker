<template>
    <div>
        <div class="task-list-header">
            <div class="task-list-header__left-block">
                <Checkbox
                    v-if="batchMode"
                    :check="check"
                    @on-checked="onChecked"
                />
            </div>
            <div class="task-list-header__name">
                <span>Name</span>
            </div>
            <div class="batch-mode-buttons">
                <div
                    v-if="batchMode"
                    class="batch-mode-buttons__button batch-mode-buttons__button--remove"
                    title="Remove items"
                    @click="batchRemove"
                >
                    <i class="far fa-trash-alt" />
                </div>
                <div
                    class="batch-mode-buttons__toggle-button"
                    :class="{ 'batch-mode-buttons__toggle-button--enabled': batchMode }"
                    title="Toggle batch mode"
                    @click="toggleBatchMode"
                >
                    <i class="fas fa-list" />
                </div>
            </div>
        </div>
        <Draggable
            :list="items"
            :options="dragOptions"
            @end="onDragEnd"
        >
            <TaskItem
                v-for="item in items"
                :id="item.id"
                :key="item.id"
                :name="item.name"
                :position="item.position"
                :batch-mode="batchMode"
                :common-check="check"
                :active-task-id="activeTaskId"
                @on-checked="onTaskChecked"
                @on-removed="onTaskRemoved"
                @on-name-updated="onTaskNameUpdated"
                @on-timer-started="onTaskTimerStarted"
            />
        </Draggable>
    </div>
</template>

<script>
    import Draggable from 'vuedraggable';
    import { mapGetters, mapActions } from 'vuex';
    import TaskItem from './TaskItem';
    import Checkbox from '../Common/Checkbox';
    import { UNCHECKED, CHECKED, INDETERMINATE } from '../Common/Checkbox';

    export default {
        name: 'TaskList',
        components: {
            TaskItem,
            Checkbox,
            Draggable,
        },
        data() {
            return {
                batchMode: false,
                check: UNCHECKED,
                checkedTasksIds: [],
                activeTaskId: null,
                dragOptions: {
                    handle: '.task-item-left-block__drag-icon',
                    chosenClass: 'task-item--drag',
                    ghostClass: 'task-item--ghost',
                    animation: 100,
                },
            };
        },
        computed: {
            ...mapGetters('task', [
                'items',
            ]),
        },
        methods: {
            ...mapActions('task', [
                'taskRename',
                'taskRemove',
                'taskMove',
            ]),
            onChecked() {
                if (this.check === UNCHECKED) {
                    this.check = CHECKED;
                    this.items.forEach(item => {
                        this.checkedTasksIds.push(item.id);
                    });

                    return;
                }

                if (this.check === CHECKED || this.check === INDETERMINATE) {
                    this.clearCheck();
                }
            },
            batchRemove() {
                this.taskRemove({
                    ids: this.checkedTasksIds,
                });

                this.clearCheck();
            },
            toggleBatchMode() {
                this.batchMode = !this.batchMode;

                if (!this.batchMode) {
                    this.clearCheck();
                }
            },
            onTaskChecked(id, check) {
                if (check === CHECKED && !this.checkedTasksIds.includes(id)) {
                    this.checkedTasksIds.push(id);
                }

                if (check === UNCHECKED && this.checkedTasksIds.includes(id)) {
                    this.checkedTasksIds.splice(this.checkedTasksIds.indexOf(id), 1);
                }

                this.updateCommonCheckWhenTaskChecked();
            },
            onTaskNameUpdated(id, name) {
                this.taskRename({
                    id: id,
                    name: name,
                });
            },
            onTaskRemoved(id) {
                this.taskRemove({
                    ids: [id],
                });
            },
            onTaskTimerStarted(id, timerStarted) {
                // получает id задачи с запущенным таймером
                // родитель передает айдишник всем потомкам
                // потомки реагируют на изменение (через watch)

                this.activeTaskId = timerStarted ? id : null;
            },
            updateCommonCheckWhenTaskChecked() {
                if (this.checkedTasksIds.length === this.items.length) {
                    this.check = CHECKED;

                    return;
                }

                if (this.checkedTasksIds.length < this.items.length && this.checkedTasksIds.length > 0) {
                    this.check = INDETERMINATE;

                    return;
                }

                this.check = UNCHECKED;
            },
            onDragEnd(e) {
                // todo: во время перетаскивания, выделение "перебрасывается" на другие элементы, т.е. привязано к позиции
                this.taskMove({
                    id: parseInt(e.item.getAttribute('data-id')),
                    position: e.newIndex,
                });
            },
            clearCheck() {
                this.check = UNCHECKED;
                this.checkedTasksIds = [];
            },
        },
    };
</script>

<style lang="less" scoped>
    @import '../../less/common';

    .flip-list-move,
    .no-move {
        transition: transform 0.25s;
    }

    .task-item--drag {}

    .task-item--ghost {}

    .task-list-header {

        .flex(row, nowrap, space-between, center);
        width: 100%;
        height: 48px;
        background-color: #f5f5f5;

        &__left-block {
            .flex(row, nowrap, center, center);
            width: 48px;
            height: 48px;
        }

        &__name {

            .flex(row, nowrap, flex-start, center);
            height: 48px;

            span {
                font-size: 13px;
                color: #aaa;
            }

        }

    }

    .batch-mode-buttons {

        .flex(row, nowrap, flex-start, flex-start);
        margin: 0 8px 0 0;

        &__button {

            .flex(row, nowrap, center, center);
            width: 32px;
            height: 32px;
            margin: 0 4px 0 0;
            cursor: pointer;
            color: #666;
            border-radius: 3px;

            &--enabled {
                color: #fff;
                background-color: #00f;
            }

            &:hover:not(&--enabled) {
                color: #333;
                background-color: rgba(0,0,0,.05);
            }

            i {
                color: inherit;
            }

        }

        &__toggle-button {

            .flex(row, nowrap, center, center);
            width: 32px;
            height: 32px;
            cursor: pointer;
            color: #666;
            border-radius: 3px;

            &--enabled {
                color: #fff;
                background-color: #00f;
            }

            &:hover:not(&--enabled) {
                background-color: rgba(0,0,0,.05);
            }

            i {
                color: inherit;
            }

        }

    }
</style>