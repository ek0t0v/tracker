<template>
    <div class="task-list">
        <div
            v-if="items.length === 0"
            class="task-list__empty"
        >
            <span>Nothing found!</span>
        </div>
        <TaskItem
            v-for="(item, index) in items"
            :id="item.id"
            :key="index"
            :name="item.name"
            :for-date="item.forDate"
            :state="item.state"
            :transfers="item.transfers"
            :repeat-type="item.repeatType"
            :repeat-value="item.repeatValue"
            :task-id-with-active-timer="taskIdWithActiveTimer"
            @on-timer-start="onTimerStart"
        />
    </div>
</template>

<script>
    import TaskItem from './TaskItem';
    import { mapGetters } from 'vuex';

    export default {
        name: 'TaskList',
        components: {
            TaskItem,
        },
        data() {
            return {
                taskIdWithActiveTimer: null,
            };
        },
        computed: {
            ...mapGetters('task', [
                'items',
            ]),
        },
        methods: {
            onTimerStart(e) {
                this.taskIdWithActiveTimer = e.id;
            },
        }
    }
</script>

<style lang="less" scoped>
    @import '../../less/style';

    .task-list {

        width: 800px;
        margin: 128px 0 0 0;

        &__empty {

            .flex(row, nowrap, center, center);
            width: 100%;

            span {
                .font(@primary-font, 16px, 500, @blue_2);
            }

        }

    }
</style>