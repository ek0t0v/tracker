<template>
    <div class="dashboard">
        <div class="dashboard-sidebar">
            <div class="dashboard-sidebar-menu">
                <router-link
                    class="dashboard-sidebar-menu__item"
                    :to="{ name: 'tasks' }"
                >
                    <i class="far fa-list-alt" />
                </router-link>
                <router-link
                    class="dashboard-sidebar-menu__item"
                    :to="{ name: 'history' }"
                >
                    <i class="fas fa-history" />
                </router-link>
                <router-link
                    class="dashboard-sidebar-menu__item"
                    :to="{ name: 'settings' }"
                >
                    <i class="fas fa-cog" />
                </router-link>
                <span
                    class="dashboard-sidebar-menu__item"
                    @click="onLogout"
                >
                    <i class="fas fa-sign-out-alt" />
                </span>
            </div>
        </div>
        <div class="dashboard-content">
            <keep-alive>
                <router-view />
            </keep-alive>
        </div>
    </div>
</template>

<script>
    import { mapActions } from 'vuex';

    export default {
        name: 'Dashboard',
        methods: {
            ...mapActions('user', [
                'userLogout',
            ]),
            onLogout() {
                this.userLogout();
            },
        },
    };
</script>

<style lang="less">
    @import '../less/style';

    .dashboard {
        .flex(row, nowrap, flex-start, flex-start);
        width: 100%;
        background-color: @background;
    }

    .dashboard-header {
        .flex(row, nowrap, flex-start, center);
        width: 100%;
        height: 128px;
        padding: 0 48px;
        box-sizing: border-box;
    }

    .dashboard-sidebar {
        .flex(column, nowrap, flex-start, flex-start);
        width: 64px;
        height: 100vh;
        background-color: blue;
        position: fixed;
    }

    .dashboard-sidebar-menu {

        .flex(column, nowrap, center, center);
        width: 100%;
        margin: 128px 0 0 0;

        &__item {

            .flex(row, nowrap, center, center);
            width: 48px;
            height: 48px;
            margin: 0 0 4px 0;
            border-radius: 3px;

            &:last-child {
                margin: 0;
            }

            &:hover {
                background-color: rgba(0,0,0,.15);
            }

            i {
                color: #fff;
                font-size: 22px;
            }

        }

    }

    .dashboard-content {
        width: 1056px;
        height: 100vh;
        background-color: #fff;
        margin: 0 0 0 64px;
    }
</style>