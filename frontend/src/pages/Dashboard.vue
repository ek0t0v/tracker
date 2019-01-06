<template>
    <div class="dashboard">
        <div class="dashboard-header-wrapper">
            <DashboardHeader :date="start" />
        </div>
        <TaskList />
    </div>
</template>

<script>
    import DashboardHeader from '../components/Dashboard/DashboardHeader';
    import { mapActions } from 'vuex';

    export default {
        name: 'Dashboard',
        components: {
            DashboardHeader,
            TaskList: () => import('../components/Task/TaskList'),
        },
        props: {
            start: {
                type: Date,
                default: null,
            },
        },
        watch: {
            start() {
                this.setDate({
                    date: this.start,
                });
                this.loadTasks({
                    start: this.start,
                });
            },
        },
        mounted() {
            this.setDate({
                date: this.start,
            });
            this.loadTasks({
                start: this.start,
            });
        },
        methods: {
            ...mapActions({
                setDate: 'setDate',
            }),
            ...mapActions('task', {
                loadTasks: 'load',
            }),
        },
    }
</script>

<style lang="less" scoped>
    @import (reference) '../less/style';

    .dashboard {
        .flex(column, nowrap, center, center);
        width: 100%;
    }

    .dashboard-header-wrapper {
        .flex(row, nowrap, center, flex-start);
        width: 100%;
    }
</style>