<template>
    <div class="timing-item">
        <div class="timing-item__left-column"></div>
        <div class="timing-item__right-column">
            <div class="timing-item__start-end">
                <span>{{ start | date }}</span>
                <span>-</span>
                <span>{{ end | date }}</span>
            </div>
            <div class="timing-item__interval">
                <span>{{ interval | date }}</span>
            </div>
        </div>
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

        .flex(row, nowrap, space-between, center);
        width: 100%;
        height: 48px;
        padding: 0 48px;
        box-sizing: border-box;
        border-bottom: 1px solid #eee;

        &:last-child {
            border: none;
        }

        &__left-column {
            .flex(row, nowrap, flex-start, flex-start);
        }

        &__right-column {
            .flex(row, nowrap, flex-start, flex-start);
        }

        &__start-end {

            .flex(row, nowrap, center, center);
            margin: 0 48px 0 0;

            span {

                color: #888;
                font-size: 15px;

                &:nth-child(2) {
                    margin: 0 3px;
                }

            }

        }

        &__interval {

            .flex(row, nowrap, center, center);

            span {
                font-weight: 600;
                font-size: 15px;
            }

        }

    }
</style>