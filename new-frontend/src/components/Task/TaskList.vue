<template>
    <div class="task-list">
        <TaskItem
            v-for="item in items"
            :id="item.id"
            :key="item.id"
            :name="item.name"
            :important="item.important"
        />
    </div>
</template>

<script>
    import TaskItem from './TaskItem';

    export default {
        name: 'TaskList',
        components: {
            TaskItem,
        },
        data() {
            return {
                items: [
                    {
                        id: 1,
                        name: 'Чтение (1h)',
                        important: false,
                    },
                    {
                        id: 2,
                        name: 'Прибраться на кухне',
                        important: true,
                    },
                    {
                        id: 3,
                        name: 'Работа над тайм-трекером',
                        important: false,
                    },
                    {
                        id: 4,
                        name: 'Упражнения',
                        important: false,
                    },
                    {
                        id: 5,
                        name: 'Чтение (1h)',
                        important: false,
                    },
                    {
                        id: 6,
                        name: 'Прибраться на кухне',
                        important: true,
                    },
                    {
                        id: 7,
                        name: 'Работа над тайм-трекером',
                        important: false,
                    },
                    {
                        id: 8,
                        name: 'Упражнения',
                        important: false,
                    },
                    {
                        id: 9,
                        name: 'Чтение (1h)',
                        important: false,
                    },
                    {
                        id: 10,
                        name: 'Прибраться на кухне',
                        important: true,
                    },
                    {
                        id: 11,
                        name: 'Работа над тайм-трекером',
                        important: false,
                    },
                    {
                        id: 12,
                        name: 'Упражнения',
                        important: false,
                    },
                    {
                        id: 13,
                        name: 'Чтение (1h)',
                        important: false,
                    },
                    {
                        id: 14,
                        name: 'Прибраться на кухне',
                        important: true,
                    },
                    {
                        id: 15,
                        name: 'Работа над тайм-трекером',
                        important: false,
                    },
                    {
                        id: 16,
                        name: 'Упражнения',
                        important: false,
                    },
                    {
                        id: 17,
                        name: 'Чтение (1h)',
                        important: false,
                    },
                    {
                        id: 18,
                        name: 'Прибраться на кухне',
                        important: true,
                    },
                    {
                        id: 19,
                        name: 'Работа над тайм-трекером',
                        important: false,
                    },
                    {
                        id: 20,
                        name: 'Упражнения',
                        important: false,
                    },
                    {
                        id: 21,
                        name: 'Чтение (1h)',
                        important: false,
                    },
                    {
                        id: 22,
                        name: 'Прибраться на кухне',
                        important: true,
                    },
                    {
                        id: 23,
                        name: 'Работа над тайм-трекером',
                        important: false,
                    },
                    {
                        id: 24,
                        name: 'Упражнения',
                        important: false,
                    },
                    {
                        id: 25,
                        name: 'Чтение (1h)',
                        important: false,
                    },
                    {
                        id: 26,
                        name: 'Прибраться на кухне',
                        important: true,
                    },
                    {
                        id: 27,
                        name: 'Работа над тайм-трекером',
                        important: false,
                    },
                    {
                        id: 28,
                        name: 'Упражнения',
                        important: false,
                    },
                    {
                        id: 29,
                        name: 'Чтение (1h)',
                        important: false,
                    },
                    {
                        id: 30,
                        name: 'Прибраться на кухне',
                        important: true,
                    },
                    {
                        id: 31,
                        name: 'Работа над тайм-трекером',
                        important: false,
                    },
                    {
                        id: 32,
                        name: 'Упражнения',
                        important: false,
                    },
                ],
            };
        },
    }
</script>

<style lang="less" scoped>
    .task-list {
        width: 800px;
        margin: 128px 0 0 0;
    }
</style>