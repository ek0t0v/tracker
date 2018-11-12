<template>
    <div class="page">
        <div class="page-content">
            <keep-alive>
                <router-view />
            </keep-alive>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'Page',
    };
</script>

<style lang="less" scoped>
    @import '../less/style';

    .page {

        .flex(column, nowrap, flex-start, center);
        width: 100%;

        &--center {
            .flex(column, nowrap, center, center);
            width: 100%;
            height: 100vh;
        }

    }

    .page-header {
        .flex(row, nowrap, flex-start, flex-start);
        width: 100%;
        padding: 24px;
        box-sizing: border-box;
        background-color: #fff;
        box-shadow: 0 4px 24px rgba(0,0,0,.15);
    }

    .page-content {
        width: 100%;
        height: auto;
        margin: 0;
        background-color: unset;
    }
</style>