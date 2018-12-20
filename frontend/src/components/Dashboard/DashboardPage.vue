<template>
    <div class="dashboard">
        <keep-alive>
            <router-view />
        </keep-alive>
    </div>
</template>

<script>
    export default {
        name: 'DashboardPage',
    }
</script>

<style lang="less">
    @import '../../less/style';

    .dashboard {
        .flex(column, nowrap, flex-start, center);
        width: 100%;
    }
</style>