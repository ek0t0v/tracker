<template>
    <div class="dashboard">
        <div class="dashboard-header-wrapper">
            <DashboardHeader />
        </div>
        <TaskList />
    </div>
</template>

<script>
    import DashboardHeader from '../components/Dashboard/DashboardHeader';
    import TaskList from '../components/Task/TaskList';
    import { mapGetters, mapActions } from 'vuex';

    export default {
        name: 'Dashboard',
        components: {
            DashboardHeader,
            TaskList,
        },
        computed: {
            ...mapGetters([
                'date',
            ]),
        },
        watch: {
            date() {
                this.setDate({
                    date: this.date,
                });
                this.loadTasks({
                    start: this.date,
                });
            },
        },
        mounted() {
            this.setDate({
                date: this.date,
            });
            this.loadTasks({
                start: this.date,
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
    @import '../less/style';

    .dashboard {
        .flex(column, nowrap, center, center);
        width: 100%;
    }

    .dashboard-header-wrapper {
        .flex(row, nowrap, center, flex-start);
        width: 100%;
    }
</style>