<template>
    <div>
        <DashboardHeader :header="'Create new task'" />
    </div>
</template>

<script>
    import DashboardHeader from '../Dashboard/DashboardHeader';

    export default {
        name: 'CreateTask',
        components: {
            DashboardHeader,
        },
    }
</script>

<style lang="less" scoped>

</style>