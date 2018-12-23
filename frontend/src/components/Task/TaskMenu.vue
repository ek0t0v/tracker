<template>
    <div class="task-menu">
        <app-menu-item
            :icon-css-class="'fas fa-pen'"
            @click.native="onEdit"
        >
            {{ $t('edit.label') }}
        </app-menu-item>
        <app-menu-item
            :icon-css-class="'fas fa-hourglass-start'"
        >
            {{ $t('timer.label') }}
        </app-menu-item>
        <app-menu-item
            :icon-css-class="'fas fa-share'"
        >
            {{ $t('transfer.label') }}
        </app-menu-item>
        <app-menu-item
            :icon-css-class="'fas fa-star'"
            :is-disabled="true"
        >
            {{ $t('markAsImportant.label') }}
        </app-menu-item>
        <app-menu-delimiter />
        <app-menu-item
            :type="'danger'"
            :icon-css-class="'fas fa-trash'"
            :close-menu-on-click="false"
        >
            {{ $t('delete.label') }}
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
        i18n: {
            messages: {
                en: {
                    edit: {
                        label: 'Edit',
                    },
                    timer: {
                        label: 'Start timer',
                    },
                    transfer: {
                        label: 'Transfer',
                    },
                    markAsImportant: {
                        label: 'Mark as important',
                    },
                    delete: {
                        label: 'Delete',
                    },
                },
                ru: {
                    edit: {
                        label: 'Редактировать',
                    },
                    timer: {
                        label: 'Запустить таймер',
                    },
                    transfer: {
                        label: 'Перенести',
                    },
                    markAsImportant: {
                        label: 'Отметить как важную',
                    },
                    delete: {
                        label: 'Удалить',
                    },
                },
            },
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
    .task-menu {}
</style>