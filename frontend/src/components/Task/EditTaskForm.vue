<template>
    <div class="edit-task-form">
        {{ id }}
    </div>
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

    .edit-task-form {}
</style>