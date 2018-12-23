<template>
    <div class="account-menu">
        <app-menu-item
            :icon-css-class="'fas fa-cog'"
            @click.native="openSettingsModal"
        >
            {{ $t('settings.label') }}
        </app-menu-item>
        <app-menu-delimiter />
        <app-menu-item
            :icon-css-class="'fas fa-sign-out-alt'"
            :type="'danger'"
        >
            {{ $t('logout.label') }}
        </app-menu-item>
    </div>
</template>

<script>
    import AppMenuItem from '../AppMenuItem';
    import AppMenuDelimiter from '../AppMenuDelimiter';
    import SettingsForm from '../Dashboard/SettingsForm';

    export default {
        name: 'AccountMenu',
        components: {
            AppMenuItem,
            AppMenuDelimiter,
        },
        i18n: {
            messages: {
                en: {
                    settings: {
                        label: 'Settings',
                    },
                    logout: {
                        label: 'Logout',
                    },
                },
                ru: {
                    settings: {
                        label: 'Настройки',
                    },
                    logout: {
                        label: 'Выход',
                    },
                },
            },
        },
        methods: {
            openSettingsModal() {
                this.$modal.open(SettingsForm, {}, 'Settings');
            },
        },
    }
</script>

<style lang="less" scoped>
    .account-menu {}
</style>