<template>
    <div class="wrap-dashboard-header">
        <div class="dashboard-header">
            <div class="dashboard-header__column">
                <div class="dashboard-header-logo"></div>
            </div>
            <div class="dashboard-header__column">
                <div class="dashboard-header-header">{{ header }}</div>
            </div>
            <div class="dashboard-header__column">
                <div class="dashboard-header-user"></div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'DashboardHeader',
        props: {
            header: {
                type: String,
                default: '',
            },
        },
    }
</script>

<style lang="less" scoped>
    @import '../../less/style';

    .wrap-dashboard-header {
        .flex(row, nowrap, center, flex-start);
        width: 100%;
        height: 128px;
    }

    .dashboard-header {

        .flex(row, nowrap, space-between, center);
        width: 1056px;
        height: 100%;

        &__column {

        }

    }

    .dashboard-header-header {
        .font(@primary-font, 24px, 700, @header_color);
    }

    .dashboard-header-logo {
        width: 48px;
        height: 48px;
        border-radius: 24px;
        background-color: #F5F5F5;
    }

    .dashboard-header-user {
        width: 48px;
        height: 48px;
        border-radius: 24px;
        background-color: #F5F5F5;
    }
</style>