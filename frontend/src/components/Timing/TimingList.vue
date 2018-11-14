<template>
    <div class="timing-list">
        <TimingItem
            v-for="item in items"
            :id="item.id"
            :key="item.id"
            :task-id="item.taskId"
            :start="item.start"
            :end="item.end"
        />
    </div>
</template>

<script>
    import TimingItem from './TimingItem';
    import { mapGetters } from 'vuex';

    export default {
        name: 'TimingList',
        components: {
            TimingItem,
        },
        computed: {
            ...mapGetters('timing', [
                'items',
            ]),
        },
    };
</script>

<style lang="less" scoped>
    @import '../../less/common';

    .timing-list {
        .flex(column, nowrap, flex-start, flex-start);
    }
</style>