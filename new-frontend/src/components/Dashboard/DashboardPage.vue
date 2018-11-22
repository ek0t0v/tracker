<template>
    <div class="dashboard">
        <router-view />
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