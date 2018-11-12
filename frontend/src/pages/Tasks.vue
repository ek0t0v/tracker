<template>
    <div>
        <div class="dashboard-header">
            <h1>Tasks [{{ tasksCount }}]</h1>
        </div>
        <TaskCreate />
        <TaskList />
    </div>
</template>

<script>
    import TaskList from '../components/Task/TaskList';
    import TaskCreate from '../components/Task/TaskCreate';
    import { mapGetters, mapActions } from 'vuex';

    export default {
        name: 'Tasks',
        components: {
            TaskList,
            TaskCreate,
        },
        computed: {
            ...mapGetters('task', [
                'tasksCount',
            ]),
        },
        mounted() {
            this.taskLoad();
        },
        methods: {
            ...mapActions('task', [
                'taskLoad',
            ]),
        },
    }
</script>

<style lang="less" scoped></style>