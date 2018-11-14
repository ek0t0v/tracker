<template>
    <div class="timing-list">
        <div
            v-if="loading"
            class="loading"
        >
            <Loader />
        </div>
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
    import Loader from '../Common/Loader';
    import { mapGetters, mapActions } from 'vuex';

    export default {
        name: 'TimingList',
        components: {
            TimingItem,
            Loader,
        },
        data() {
            return {
                loading: true,
            };
        },
        computed: {
            ...mapGetters('timing', [
                'items',
            ]),
        },
        watch: {
            items() {
                if (this.items.length > 0) {
                    this.loading = false;
                }
            },
        },
        mounted() {
            this.timingLoad();
        },
        methods: {
            ...mapActions('timing', [
                'timingLoad',
            ]),
        },
    };
</script>

<style lang="less" scoped>
    @import '../../less/common';

    .loading {
        .flex(row, nowrap, center, center);
        width: 100%;
        height: 128px;
    }

    .timing-list {
        .flex(column, nowrap, flex-start, flex-start);
    }
</style>