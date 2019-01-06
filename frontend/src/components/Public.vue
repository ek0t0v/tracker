<template>
    <div class="public">
        <div class="public-header">
            <i class="public-header__logo far fa-calendar-check" />
            <ul class="public-header__menu">
                <li class="public-header__menu-item">
                    <router-link
                        class="public-header__menu-link"
                        :to="{ name: 'home' }"
                    >
                        Home
                    </router-link>
                </li>
                <li class="public-header__menu-item">
                    <router-link
                        class="public-header__menu-link"
                        :to="{ name: 'login' }"
                    >
                        Log in
                    </router-link>
                </li>
                <li class="public-header__menu-item">
                    <router-link
                        class="public-header__menu-link"
                        :to="{ name: 'login' }"
                    >
                        Sign up
                    </router-link>
                </li>
            </ul>
        </div>
        <div class="public-content">
            <keep-alive>
                <router-view />
            </keep-alive>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'Public',
    }
</script>

<style lang="less" scoped>
    @import '../less/style';

    .public {
        .flex(column, nowrap, flex-start, flex-start);
        width: 100%;
        min-height: 100vh;
        background-color: #F5F5F5;
    }

    .public-header {

        .flex(row, nowrap, space-between, center);
        width: 100%;
        box-sizing: border-box;
        position: fixed;
        background-color: #fff;
        box-shadow: 0 15px 35px rgba(50,50,95,.04), 0 5px 10px rgba(0,0,0,.02);

        &__logo {
            color: #fff;
            font-size: 40px;
        }

        &__menu {
            .flex(row, nowrap, flex-end, flex-start);
        }

        &__menu-item {
            display: flex;
        }

        &__menu-link {

            .font(@primary-font, 16px, 600, @header_color);
            padding: 16px 24px;
            transition: .1s all ease-in-out;

            &:hover {
                background-color: @blue_5;
            }

        }

    }

    .public-content {
        .flex(column, nowrap, center, center);
        width: 100%;
        height: 100vh;
    }
</style>