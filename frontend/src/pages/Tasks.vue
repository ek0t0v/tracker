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
    import { mapGetters } from 'vuex';

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
    };
</script>

<style lang="less" scoped></style>