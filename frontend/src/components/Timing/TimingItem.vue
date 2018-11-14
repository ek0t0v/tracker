<template>
    <div class="timing-item">
        <span>{{ start | date }}</span> | <span>{{ end | date }}</span> | <span>{{ interval | date }}</span>
    </div>
</template>

<script>
    import moment from 'moment';

    export default {
        name: 'TimingItem',
        filters: {
            date(value) {
                if (!value) {
                    return '';
                }

                return moment(value).format('HH:mm:ss');
            },
        },
        props: {
            id: {
                type: Number,
                default: null,
            },
            taskId: {
                type: Number,
                default: null,
            },
            start: {
                type: Date,
                default: null,
            },
            end: {
                type: Date,
                default: null,
            },
        },
        computed: {
            interval() {
                // todo: Что если таймер дойдет до 1 суток? Думаю в таком случае сгружать тайминг и запускать таймер заново.

                let time = new Date(1970, 0, 1);
                time.setSeconds(Math.floor(this.end.getTime() / 1000) - Math.floor(this.start.getTime() / 1000));

                return time;
            },
        },
    };
</script>

<style lang="less" scoped>
    @import '../../less/common';

    .timing-item {
        .flex(row, nowrap, flex-start, flex-start);
        width: 100%;
    }
</style>