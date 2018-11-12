<template>
    <div class="page">
        <h1>Home</h1>
        <router-link :to="{ name: 'login' }">Log in</router-link>
    </div>
</template>

<script>
    export default {
        name: 'Home',
    };
</script>

<style lang="less" scoped></style>