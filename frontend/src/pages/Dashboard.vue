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
                    headerText = 'Today';
                } else if (moment(this.start).isSame(moment().subtract(1, 'days'), 'day')) {
                    headerText = 'Yesterday';
                } else if (moment(this.start).isSame(moment().add(1, 'days'), 'day')) {
                    headerText = 'Tomorrow';
                } else if (moment(this.start).year() === moment().year()) {
                    headerText = moment(this.start).format('MMMM Do');
                } else {
                    headerText = moment(this.start).format('MMMM Do YYYY');
                }

                return headerText;
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