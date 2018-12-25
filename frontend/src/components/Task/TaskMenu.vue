<template>
    <div class="task-menu">
        <app-menu-item
            :icon-css-class="$t('taskMenu.edit.iconCssClass')"
            @click.native="onEdit"
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
            :icon-css-class="$t('taskMenu.markAsImportant.iconCssClass')"
            :is-disabled="true"
        >
            {{ $t('taskMenu.markAsImportant.label') }}
        </app-menu-item>
        <app-menu-delimiter />
        <app-menu-item
            :type="'danger'"
            :icon-css-class="$t('taskMenu.delete.iconCssClass')"
            :close-menu-on-click="false"
        >
            {{ $t('taskMenu.delete.label') }}
        </app-menu-item>
    </div>
</template>

<script>
    import AppMenuItem from '../AppMenuItem';
    import AppMenuDelimiter from '../AppMenuDelimiter';
    import EditTaskForm from '../Task/EditTaskForm';

    export default {
        name: 'TaskMenu',
        components: {
            AppMenuItem,
            AppMenuDelimiter,
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
        },
        methods: {
            onEdit() {
                this.$modal.open(EditTaskForm, {
                    id: this.id,
                }, this.name);
            },
        },
    }
</script>

<style lang="less" scoped>
    .task-menu {
        padding: 8px 0;
    }
</style>