<template>
    <div class="root">
        <div class="dashboard-header-wrapper">
            <DashboardHeader>Settings</DashboardHeader>
        </div>
    </div>
</template>

<script>
    import DashboardHeader from '../components/Dashboard/DashboardHeader';

    export default {
        name: 'Settings',
        components: {
            DashboardHeader,
        },
    }
</script>

<style lang="less" scoped>
    @import '../less/style';
</style>