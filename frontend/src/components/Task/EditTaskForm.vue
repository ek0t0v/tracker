<template>
    <div class="edit-task-form"></div>
</template>

<script>
    export default {
        name: 'EditTaskForm',
        props: {
            id: {
                type: Number,
                default: null,
            },
        },
    }
</script>

<style lang="less" scoped>
    @import '../../less/style';

    .edit-task-form {
        width: 360px;
    }
</style>