<template>
    <div class="confirm-modal">
        <button
            class="common-button"
            @click="execute"
        >
            OK
        </button>
        <button
            class="common-button"
            @click="close"
        >
            Cancel
        </button>
    </div>
</template>

<script>
    export default {
        name: 'AppConfirmModal',
        props: {
            action: {
                type: Function,
                default: null,
            },
            payload: {
                type: Object,
                default: () => {},
            },
        },
        methods: {
            execute() {
                this.action(this.payload);

                this.close();
            },
            close() {
                this.$modal.close();
            },
        },
    }
</script>

<style lang="less" scoped>
    @import (reference) '../less/style';

    .confirm-modal {}
</style>