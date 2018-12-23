<template>
    <div class="app">
        <keep-alive>
            <router-view />
        </keep-alive>
        <app-modal />
        <app-menu />
    </div>
</template>

<script>
    import AppModal from './AppModal';
    import AppMenu from './AppMenu';

    export default {
        name: 'App',
        components: {
            AppModal,
            AppMenu,
        },
    }
</script>

<style lang="less">
    @import '../less/style';

    .app {
        .flex(column, nowrap, flex-start, center);
        width: 100%;
    }
</style>