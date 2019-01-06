<template>
    <div class="account-menu">
        <app-menu-item
            :icon-css-class="$t('accountMenu.settings.iconCssClass')"
            @click.native="openSettingsModal"
        >
            {{ $t('accountMenu.settings.label') }}
        </app-menu-item>
        <app-menu-delimiter />
        <app-menu-item
            :color="'red'"
            :icon-css-class="$t('accountMenu.logout.iconCssClass')"
            @click.native="userLogout"
        >
            {{ $t('accountMenu.logout.label') }}
        </app-menu-item>
    </div>
</template>

<script>
    import AppMenuItem from '../AppMenuItem';
    import AppMenuDelimiter from '../AppMenuDelimiter';
    import SettingsForm from '../Dashboard/SettingsForm';
    import { mapActions } from 'vuex';

    export default {
        name: 'AccountMenu',
        components: {
            AppMenuItem,
            AppMenuDelimiter,
        },
        methods: {
            ...mapActions('user', {
                userLogout: 'userLogout',
            }),
            openSettingsModal() {
                this.$modal.open(SettingsForm, {}, {
                    header: this.$t('modal.header.settings'),
                });
            },
        },
    }
</script>

<style lang="less" scoped>
    .account-menu {
        padding: 8px 0;
    }
</style>