<template>
    <div>
        <div class="dashboard-header">
            <h1>History [{{ timingsCount }}]</h1>
        </div>
        <TimingList />
    </div>
</template>

<script>
    import TimingList from '../components/Timing/TimingList';
    import { mapGetters } from 'vuex';

    export default {
        name: 'History',
        components: {
            TimingList,
        },
        computed: {
            ...mapGetters('timing', [
                'timingsCount',
            ]),
        },
    };
</script>

<style lang="less" scoped></style>