<template>
    <div class="task-menu">
        <app-menu-item
            :icon-css-class="$t('taskMenu.edit.iconCssClass')"
            @click.native="editTask"
        >
            {{ $t('taskMenu.edit.label') }}
        </app-menu-item>
        <app-menu-item
            :icon-css-class="$t('taskMenu.timer.iconCssClass')"
        >
            {{ $t('taskMenu.timer.label') }}
        </app-menu-item>
        <app-menu-item
            :icon-css-class="$t('taskMenu.transfer.iconCssClass')"
        >
            {{ $t('taskMenu.transfer.label') }}
        </app-menu-item>
        <app-menu-item
            :icon-css-class="$t('taskMenu.cancel.iconCssClass')"
            @click.native="cancelTask"
        >
            {{ $t('taskMenu.cancel.label') }}
        </app-menu-item>
        <app-menu-item
            :icon-css-class="$t('taskMenu.markAsImportant.iconCssClass')"
        >
            {{ $t('taskMenu.markAsImportant.label') }}
        </app-menu-item>
        <app-menu-delimiter />
        <app-menu-item
            :color="'red'"
            :icon-css-class="$t('taskMenu.delete.iconCssClass')"
            @click.native="removeTask"
        >
            {{ $t('taskMenu.delete.label') }}
        </app-menu-item>
    </div>
</template>

<script>
    import AppMenuItem from '../AppMenuItem';
    import AppMenuDelimiter from '../AppMenuDelimiter';
    import EditTaskForm from '../Task/EditTaskForm';
    import AppConfirmModal from '../AppConfirmModal';
    import { mapActions } from 'vuex';

    export default {
        name: 'TaskMenu',
        components: {
            AppMenuItem,
            AppMenuDelimiter,
        },
        props: {
            task: {
                type: Object,
                default: null,
            },
            id: {
                type: Number,
                default: null,
            },
            name: {
                type: String,
                default: '',
            },
        },
        methods: {
            ...mapActions('task', [
                'setState',
                'remove',
            ]),
            editTask() {
                this.$modal.open(EditTaskForm, {
                    id: this.task.id,
                }, {
                    header: this.task.name,
                });
            },
            cancelTask() {
                this.$modal.open(AppConfirmModal, {
                    action: this.setState,
                    payload: {
                        id: this.task.id,
                        forDate: this.task.forDate,
                        state: 'cancelled',
                    },
                }, {
                    header: 'Отменить задачу',
                });
            },
            removeTask() {
                this.$modal.open(AppConfirmModal, {
                    action: this.remove,
                    payload: {
                        id: this.task.id,
                    },
                }, {
                    header: 'Удалить задачу',
                });
            },
        },
    }
</script>

<style lang="less" scoped>
    .task-menu {
        padding: 8px 0;
    }
</style>