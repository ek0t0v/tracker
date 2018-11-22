<template>
    <div class="root">
        <DashboardHeader :header="'Today'" />
        <TaskList />
    </div>
</template>

<script>
    import DashboardHeader from '../Dashboard/DashboardHeader';
    import TaskList from '../Task/TaskList';

    export default {
        name: 'Home',
        components: {
            DashboardHeader,
            TaskList,
        },
    }
</script>

<style lang="less" scoped>
    @import '../../less/style';

    .root {
        .flex(column, nowrap, center, center);
    }
</style>