<template>
    <div>
        <div class="dashboard-header">
            <h1>Tasks [{{ tasksCount }}]</h1>
        </div>
        <TaskCreate />
        <TaskList />
        <TimingList />
    </div>
</template>

<script>
    import TaskList from '../components/Task/TaskList';
    import TaskCreate from '../components/Task/TaskCreate';
    import TimingList from '../components/Timing/TimingList';
    import { mapGetters, mapActions } from 'vuex';

    export default {
        name: 'Tasks',
        components: {
            TaskList,
            TaskCreate,
            TimingList,
        },
        computed: {
            ...mapGetters('task', [
                'tasksCount',
            ]),
        },
        mounted() {
            this.taskLoad();
            this.timingLoad();
        },
        methods: {
            ...mapActions('task', [
                'taskLoad',
            ]),
            ...mapActions('timing', [
                'timingLoad',
            ]),
        },
    };
</script>

<style lang="less" scoped></style>