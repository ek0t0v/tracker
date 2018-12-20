<template>
    <div class="account-menu">
        <router-link
            class="account-menu__item"
            :to="{ name: 'dashboard' }"
        >
            <span>Dashboard</span>
        </router-link>
        <router-link
            class="account-menu__item"
            :to="{ name: 'settings' }"
        >
            <span>Settings</span>
        </router-link>
        <div class="account-menu__divider" />
        <div class="account-menu__item account-menu__item--danger">
            <span>Logout</span>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'AccountMenu',
    }
</script>

<style lang="less" scoped>
    @import '../../less/style';

    .account-menu {

        .noselect;
        width: 180px;
        padding: 6px 0;
        box-sizing: border-box;
        border-radius: 3px;
        background-color: #fff;
        box-shadow: 0 0 0 1px rgba(29,44,76,.1), 0 4px 8px rgba(0,0,0,.15);
        z-index: 100000000;
        will-change: transform;
        position: absolute;

        &:before,
        &:after {
            content: '';
            display: block;
            position: absolute;
            left: 80px;
            width: 0;
            height: 0;
            border-style: solid;
        }

        &:after {
            top: -20px;
            border-color: transparent transparent #fff transparent;
            border-width: 10px;
        }

        &:before {
            top: -21px;
            border-color: transparent transparent #e6e7eb transparent;
            border-width: 10px;
        }

        &__item {

            width: 100%;
            box-sizing: border-box;
            display: block;
            color: @blue_1;
            padding: 8px 16px;
            cursor: pointer;
            transition: .1s all ease-in-out;

            &:hover {
                background-color: @blue_5;
            }

            &--danger {

                color: #D60000;

                &:hover {
                    background-color: rgba(214,0,0,.05) !important;
                }

            }

            span {
                .font(@primary-font, 14px, 400, inherit);
            }

        }

        &__divider {
            margin: 6px 0;
            border-bottom: 1px solid @blue_4;
        }
    }
</style>