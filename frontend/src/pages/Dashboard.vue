<template>
    <div class="dashboard">
        <div class="dashboard-header-wrapper">
            <DashboardHeader>{{ headerText }}</DashboardHeader>
        </div>
        <TaskList />
    </div>
</template>

<script>
    import DashboardHeader from '../components/Dashboard/DashboardHeader';
    import TaskList from '../components/Task/TaskList';
    import { mapActions } from 'vuex';
    import moment from 'moment';

    export default {
        name: 'Dashboard',
        components: {
            DashboardHeader,
            TaskList,
        },
        props: {
            start: {
                type: Date,
                default: null,
            },
        },
        computed: {
            headerText() {
                let headerText;

                if (moment(this.start).isSame(moment(), 'day')) {
                    headerText = this.$t('headerText.today');
                } else if (moment(this.start).isSame(moment().subtract(1, 'days'), 'day')) {
                    headerText = this.$t('headerText.yesterday');
                } else if (moment(this.start).isSame(moment().add(1, 'days'), 'day')) {
                    headerText = this.$t('headerText.tomorrow');
                } else if (moment(this.start).year() === moment().year()) {
                    headerText = moment(this.start).format(this.$t('headerText.thisYearDateFormat'));
                } else {
                    headerText = moment(this.start).format(this.$t('headerText.anotherYearDateFormat'));
                }

                return headerText;
            },
        },
        i18n: {
            messages: {
                en: {
                    headerText: {
                        yesterday: 'Yesterday',
                        today: 'Today',
                        tomorrow: 'Tomorrow',
                        thisYearDateFormat: 'MMMM Do',
                        anotherYearDateFormat: 'MMMM Do YYYY',
                    },
                },
                ru: {
                    headerText: {
                        yesterday: 'Вчера',
                        today: 'Сегодня',
                        tomorrow: 'Завтра',
                        thisYearDateFormat: 'D MMMM',
                        anotherYearDateFormat: 'D MMMM YYYY',
                    },
                },
            },
        },
        watch: {
            start() {
                this.load(this.start);
            },
        },
        mounted() {
            this.load(this.start);
        },
        methods: {
            ...mapActions('task', {
                load: 'load',
            }),
        },
    }
</script>

<style lang="less" scoped>
    @import '../less/style';

    .dashboard {
        .flex(column, nowrap, center, center);
        width: 100%;
    }

    .dashboard-header-wrapper {
        .flex(row, nowrap, center, flex-start);
        width: 100%;
    }
</style>